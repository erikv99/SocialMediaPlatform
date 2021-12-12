<?php  
require_once("model.php");

class ProposalModel extends Model 
{
	public function execute() : array 
	{
		$returnData = [];
		
		// Checking if user is logged in, else returning with a alert informing the user
    	if (!$this->isUserLoggedIn()) 
     	{
     		$this->dieWithAlert("alertInfo", "Must be logged in to create a proposal");
    	}

    	// Handeling the possible data in the post var.
		$executedAction = $this->handlePostData();
		
		// Checking if any action has been executed
		if ($executedAction != "none") 
		{
			$returnData["messageType"] = "alertInfo";
			$returnData["message"] = $this->getAlertMessage($executedAction);
		}
		
		// Checking if the user is a admin, if so setting the viewType to admin else normal
		$viewType = $this->isUserAdmin() ? "admin" : "normal";
		$returnData["viewType"] = $viewType;

		// Getting the primary subjects, needed in the view.
		$primarySubjects = $this->getPrimarySubjects();
		$returnData["primarySubjects"] = $primarySubjects;

		// Setting the locations for the locationsbar
		$returnData["locations"] = 
		[
			"Subject proposal" => "callController('.content', 'proposalController')",
		];

		return $returnData;
	}

	/**
	 * Function will check the post data for arguments and handle them if needed, returns a string specifying the executed action/
	 * 
	 * @return string $executedAction
	 */
	private function handlePostData() 
	{	
		// Escaping the data from the post.
		$postData = htmlspecialchars($_POST['data'], ENT_QUOTES | ENT_HTML5, 'UTF-8', /*double_encode*/false );

		// Splitting the post data on the comma to get the data send to the controller
		$temp = explode("|", $postData);

		// If the first arg is empty we dont have to do anything, else we handle the args
		if ($temp[0] == "") 
		{ 
			return "none"; 
		} 
		
		$actionType = $temp[0];

		// Getting the title also making the first character capitalized
		$proposalTitle = $temp[1];

		// Checking if the required action is rejecting or approving a proposal
		if ($actionType == "approveProposal" or $actionType == "rejectProposal") 
		{
			$proposalType = $temp[2];
			switch ($actionType) 
			{
				case "approveProposal":
					$this->approveProposal($proposalTitle, $proposalType);
					return "approvedProposal";
				
				case "rejectProposal":
					$this->rejectProposal($proposalTitle, $proposalType);
					return "rejectedProposal";
			}
		}

		// Checking if the required action is saving a primary or secondary proposal.
		if ($actionType == "proposeSecondary" or $actionType == "proposePrimary") 
		{

			// Getting the content and escaping it, also making the first character capitalized
			$proposalReason = $temp[2];
			
			// Checking if the title and reason atleast contain a letter each.
			$this->validateInput($proposalTitle, $proposalReason);
			
			switch ($actionType) 
			{
				case 'proposeSecondary':
					$primarySubject = $temp[3];

					$this->saveSecondaryProposal($proposalTitle, $proposalReason, $primarySubject);
					break;
					
				case "proposePrimary":
					$this->savePrimaryProposal($proposalTitle, $proposalReason);
					break;
			}

			return "savedProposal";
		}
		
		// Returning none here just in case for some reason we get something that is not "" in the actionType but also is not a valid
		return "none";
	}

	/**
	 * Checks if the title and reason both atleast contain one letter. otherwise displays a error message
	 * 
	 * @param string $proposalTitle
	 * @param string $proposalReason
	 */
	private function validateInput(string $proposalTitle, string $proposalReason) 
	{
		// Checking if title contains atleast 1 letter.
		if (!preg_match('/[A-Za-z]/', $proposalTitle)) 
		{
			$this->dieWithAlert("alertError", "Title must atleast be 1 letter");
		}

		// Checking if reason contains atleast 1 letter.
		if (!preg_match('/[A-Za-z]/', $proposalReason)) 
		{
			$this->dieWithAlert("alertError", "Reason must atleast be 1 letter");
		}
	}

	/**
	 * Saves a primary subject proposal
	 * 
	 * @param string $proposalTitle
	 * @param string $proposalReason
	 */
	private function savePrimaryProposal(string $proposalTitle, string $proposalReason) 
	{
		// Checking if it already exists
		if ($this->doesPrimaryProposalExist($proposalTitle)) 
		{
			$this->dieWithAlert("alertError", "Proposal already exists");
		}
		
		$proposalCreator = $_SESSION['username'];

		// Opening a DB connection
		$dbConn = openDBConnection();

		try 
		{
			$stmt = $dbConn->prepare("INSERT INTO primaryProposals (proposalCreator, proposalTitle, proposalReason) VALUES (?, ?, ?)");
			$stmt->execute([$proposalCreator, $proposalTitle, $proposalReason]);
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		closeDBConnection($dbConn);
	}

	/**
	 * Saves a secondary subject proposal
	 * 
	 * @param string $proposalTitle
	 * @param string $proposalReason
	 * @param string $primarySubject
	 */
	private function saveSecondaryProposal(string $proposalTitle, string $proposalReason, string $primarySubject)
	{
		// Checking if it already exists
		if ($this->doesSecondaryProposalExist($proposalTitle, $primarySubject)) 
		{
			$this->dieWithAlert("alertError", "Proposal already exists");
		}

		$proposalCreator = $_SESSION['username'];

		// Opening a DB connection
		$dbConn = openDBConnection();

		try 
		{
			$stmt = $dbConn->prepare("INSERT INTO secondaryProposals (proposalCreator, proposalTitle, proposalReason, proposalPrimary) VALUES (?, ?, ?, ?)");
			$stmt->execute([$proposalCreator, $proposalTitle, $proposalReason, $primarySubject]);
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		closeDBConnection($dbConn);
	}

	/**
	 * Checks if the given primary proposal already exists. returns a bool
	 * 
	 * @param string $proposalTitle
	 * @return bool $proposalExists
	 */
	private function doesPrimaryProposalExist(string $proposalTitle)  
	{
		// Opening a DB connection and checking if the given username is present in our data table
		$dbConnection = openDBConnection();

		try 
		{
			$stmt = $dbConnection->prepare("SELECT COUNT(proposalTitle) FROM primaryproposals WHERE proposalTitle = ?");
			$stmt->execute([$proposalTitle]);
			$output = $stmt->fetch()["COUNT(proposalTitle)"];
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());

		}

		// If the username is present $doesUserExist will be true otherwise it shall be false.
		$proposalExists = ($output > 0) ? true : false;

		// Closing the DB connection and returning the result
		closeDBConnection($dbConnection);
		return $proposalExists;
	}

	/**
	 * Checks if the given secondary proposal already exists. returns a bool
	 * 
	 * @param string $proposalTitle
	 * @param string $primarySubject
	 * @return bool $proposalExists
	 */
	private function doesSecondaryProposalExist(string $proposalTitle, $primarySubject)
	{
		// Opening a DB connection and checking if the given username is present in our data table
		$dbConnection = openDBConnection();

		try 
		{
			$stmt = $dbConnection->prepare("SELECT COUNT(proposalTitle) FROM secondaryproposals WHERE proposalTitle = ? AND proposalprimary = ?");
			$stmt->execute([$proposalTitle, $primarySubject]);
			$output = $stmt->fetch()["COUNT(proposalTitle)"];
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());

		}

		// If the username is present $doesUserExist will be true otherwise it shall be false.
		$proposalExists = ($output > 0) ? true : false;

		// Closing the DB connection and returning the result
		closeDBConnection($dbConnection);
		return $proposalExists;
	}

	/**
	 * Returns the correct alert message depending on which action has been executed. 
	 * 
	 * @param string $executedAction
	 * @return string $alertMessage
	 */
	private function getAlertMessage($executedAction) : string 
	{
		// Getting the correct message depending on the executed action.
		switch ($executedAction) 
		{
			case "savedProposal":
				return "Subject has been proposed!";
			
			case "approvedProposal":
				return "Proposal has been approved!";
			
			case "rejectedProposal":
				return "Proposal has been rejected!";	
		}
	}

	/**
	 * Will approve the proposal with the given title
	 * 
	 * @param string $proposalTitle
	 * @param string $proposalType
	 * @param string $primarySubject (only needed for secondary subject)
	 */
	private function approveProposal(string $proposalTitle, string $proposalType, string $primarySubject = "") 
	{
		// Removing the current proposal from the db
		$this->removeProposal($proposalTitle, $proposalType);

		// checking which type of proposal was approved.
		if ($proposalType == "primary") 
		{
			// When adding a primary subject proposel the first secondary subject is needed. that why we start those off with a 'general'
			$this->createSubject($proposalTitle, "General");
		}
		elseif ($proposalType == "secondary") 
		{
			if ($primarySubject == "") 
			{
				logError("PrimarySubject was empty when approving a secondary subject!");
			}
			$this->createSubject($primarySubject, $proposalTitle);
		}
	}

	/**
	 * Will reject the proposal with the given title
	 * 
	 * @param string $proposalTitle
	 * @param string $proposalType
	 */
	private function rejectProposal(string $proposalTitle, string $proposalType) 
	{
		// Removing the current proposal from the db
		$this->removeProposal($proposalTitle, $proposalType);
	}

	/**
	 * Removes the proposal from the database
	 * 
	 * @param string $proposalTitle (dont worry this is unique)
	 * @param string $proposalType
	 */
	private function removeProposal(string $proposalTitle, string $proposalType) 
	{
		if (!($proposalType == "primary" or $proposalType == "secondary")) 
		{
			logError("Cant remove proposal, invalid proposal type given");
			return;
		}

		$tableName = "";
		
		if ($proposalType == "primary") 
		{
			$tableName = "primaryproposals";
		}
		else 
		{
			$tableName = "secondaryproposals";
		}

		$dbConnection = openDBConnection();

		try 
		{
			$stmt = $dbConnection->prepare("DELETE FROM $tableName WHERE proposalTitle = ?");
			$stmt->execute([$proposalTitle]);
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());

		}

		// Closing the DB connection
		closeDBConnection($dbConnection);
	}

	/**
	 * Creates a new entry in the subjects db table.
	 * 
	 * @param string $primarySubject
	 * @param string $secondarySubject
	 */
	private function createSubject(string $primarySubject, string $secondarySubject) 
	{
		$dbConnection = openDBConnection();

		try 
		{
			$stmt = $dbConnection->prepare("INSERT INTO subjects (primarysubject, secondarysubject) VALUES (?, ?)");
			$stmt->execute([$primarySubject, $secondarySubject]);
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());

		}

		// Closing the DB connection
		closeDBConnection($dbConnection);
	}
}
?>