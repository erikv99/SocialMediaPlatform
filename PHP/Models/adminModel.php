<?php  
require_once("model.php");

/** specific model class for the admin page */
class AdminModel extends Model 
{
	private array $secondarySubjects = [];

	/** 
	 * Executes the logic required for the specific model, sets any needed output and returns it.
	 * 
	 * @return array $output
	 */
	public function execute() : array 
	{
		$returnData = [];
		$secondarySubjects = [];
		// Checking if the user is a admin, only relevant if the user manually changes the display of the button.
		if (!$this->isUserAdmin()) 
		{
			$this->dieWithAlert("alertWarning", "No permission to access the admin page");
		}

		$this->handleGivenArguments();
		
		// Getting a array of only the primary subjects
		$primarySubjects = $this->getPrimarySubjects();
		$returnData["primarySubjects"] = $primarySubjects;

		// Getting a array with all subjects
		// Key = primarysubject Value = array of secondary subjects.
		$returnData["subjects"] = $this->getSubjects();

		// Checking if the secondary subjects array is empty
		if (empty($secondarySubjects)) 
		{
			// If the secondarySubjects array is empty it means user loaded it for the first time.
			// We will show the secondarySubjects of the first primary (the one automatically selected) 
			$secondarySubjects = $this->getSecondarySubjects($primarySubjects[0]);
		}
		
		$returnData["secondarySubjects"] = $secondarySubjects;

		// Setting the locations for the locationsbar
		$returnData["locations"] = 
		[
			"Admin" => "callController('.content', 'adminController')"
		];

		return $returnData;
	}

	/** 
	 * Handles the arguments that we're send to this controller and executes the correct action.
	 */
	private function handleGivenArguments() 
	{
		// Getting the given args by splitting the post data
		$args = explode("|", $_POST["data"]);

		// Checking if args at index 0 is set
		if (isset($args[0])) 
		{	
			// Getting the action type
			$actionType = $args[0];

			// Executing the right action depending on the action type
			switch ($actionType) 
			{
				case "loadSecondaries":
					$primary = $args[1];
					$secondarySubjects = $this->getSecondarySubjects($primarySubject);
					break;

				case "deletePrimary":
					$primary = htmlspecialchars($args[1] , ENT_QUOTES | ENT_HTML5, 'UTF-8');
					$this->deletePrimary($primary);
					break;
		
				case "deleteSecondary":
					$primary = htmlspecialchars($args[1] , ENT_QUOTES | ENT_HTML5, 'UTF-8');
					$secondary = htmlspecialchars($args[2] , ENT_QUOTES | ENT_HTML5, 'UTF-8');
					$this->deleteSecondary($primary, $secondary);
					break;
			}
		}
	}

	/** 
	 * Deletes a primary subject (INCLUDING ALL ITS SECONDARY SUBJECTS, POSTS AND SECONDARY SUBJECT PROPOSALS) 
	 * 
	 * @param string $primarySubject
	 */
	private function deletePrimary(string $primarySubject) 
	{
		$dbConn = openDBConnection();

		try
		{
			// Deleting from subjects
			$stmt = $dbConn->prepare("DELETE FROM subjects where primarysubject = ?");
			$stmt->execute([$primarySubject]);

			// Deleting from posts
			$stmt = $dbConn->prepare("DELETE FROM posts where primarysubject = ?");
			$stmt->execute([$primarySubject]);

			// Deleting from secondary subject proposals
			$stmt = $dbConn->prepare("DELETE FROM secondaryproposals where proposalPrimary = ?");
			$stmt->execute([$primarySubject]);
		}
		catch (PDOException $e)
		{
			throw new DBException($e->getMessage());
		}	

		closeDBConnection($conn);

		// Calling the admin controller to refresh the admin page (cant use normal refresh since admin info is not saved in callController) then calling the alert.
		echo json_encode(["view" => "<script type='text/javascript'>callController(\".content\",\"adminController\"); callController(\".page\", \"alertController\", {\"alertType\":\"alertInfo\",\"alertMessage\":\"Primary subject has been deleted\"});</script>"]);
   		die();

	}

	/** 
	 * Deletes a secondary subject (INCLUDING ALL POSTS UNDER THIS SECONDARY SUBJECT!) 
	 * 
	 * @param string $primarySubject
	 * @param string $secondarySubject
	 */
	private function deleteSecondary(string $primarySubject, string $secondarySubject) 
	{
		$dbConn = openDBConnection();

		try
		{
			// Deleting from subjects
			$stmt = $dbConn->prepare("DELETE FROM subjects where primarysubject = ? and secondarysubject = ?");
			$stmt->execute([$primarySubject, $secondarySubject]);

			// Deleting from posts
			$stmt = $dbConn->prepare("DELETE FROM posts where primarysubject = ? and secondarysubject = ?");
			$stmt->execute([$primarySubject, $secondarySubject]);
		}
		catch (PDOException $e)
		{
			throw new DBException($e->getMessage());
		}	

		closeDBConnection($conn);

		// Calling the admin controller to refresh the admin page (cant use normal refresh since admin info is not saved in callController) then calling the alert.
		echo json_encode(["view" => "<script type='text/javascript'>callController(\".content\",\"adminController\"); callController(\".page\", \"alertController\", {\"alertType\":\"alertInfo\",\"alertMessage\":\"Secondary subject has been deleted\"});</script>"]);
   		die();
	}
}
?>