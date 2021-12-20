<?php  
require_once("model.php");

/** specific model class for the admin page */
class AdminModel extends Model 
{
	/** 
	 * Executes the logic required for the specific model, sets any needed output and returns it.
	 * 
	 * @return array $output
	 */
	public function execute() : array 
	{
		$returnData = [];

		// Checking if the user is a admin, only relevant if the user manually changes the display of the button.
		if (!$this->isUserAdmin()) 
		{
			$this->dieWithAlert("alertWarning", "No permission to access the admin page");
		}

		$this->handleGivenArguments();
		
		// Getting a array of only the primary subjects
		$returnData["primarySubjects"] = $this->getPrimarySubjects();

		// Getting a array with all subjects
		// Key = primarysubject Value = array of secondary subjects.
		$returnData["subjects"] = $this->getSubjects();

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

		logDebug("args: " . var_export($args,true));

		// Checking if args at index 0 is set
		if (isset($args[0])) 
		{	
			// Getting the action type
			$actionType = $args[0];

			// Executing the right action depending on the action type
			switch ($actionType) 
			{
				case "deletePrimary":
					$primary = $args[1];
					$this->deletePrimary($primary);
					break;
		
				case "deleteSecondary":
					$primary = $args[1];
					$secondary = $args[2];
					$this->deleteSecondary($primary, $secondary);
					break;
			}
		}
	}

	/** 
	 * Deletes a primary subject (INCLUDING ALL ITS SECONDARY SUBJECTS AND POSTS UNDER THESE SECONDARY SUBJECTS!) 
	 * 
	 * @param string $primarySubject
	 */
	private function deletePrimary(string $primarySubject) 
	{

	}

	/** 
	 * Deletes a secondary subject (INCLUDING ALL POSTS UNDER THIS SECONDARY SUBJECT!) 
	 * 
	 * @param string $primarySubject
	 * @param string $secondarySubject
	 */
	private function deleteSecondary(string $primarySubject, string $secondarySubject) 
	{

	}
}
?>