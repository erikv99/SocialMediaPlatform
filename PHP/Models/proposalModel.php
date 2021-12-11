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

		$subjectIsProposed = $this->handlePostData();
		
		if ($subjectIsProposed) 
		{
			$returnData["message"] = "Subject has been proposed!";
			$returnData["messageType"] = "alertSuccess";
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
	 * Function will check the post data for arguments and handle them if needed, returns true if a subject has been proposed, else false.
	 * 
	 * @return bool $isASubjectProposed
	 */
	private function handlePostData() 
	{
		// Splitting the post data on the comma to get the data send to the controller
		$temp = explode("|", $_POST['data']);

		// If the first arg is empty we dont have to do anything, else we handle the args
		if ($temp[0] != "") 
		{
			$proposalType = $temp[0];
			$proposalTitle = htmlentities(ucfirst($temp[1]));
			$proposalReason = htmlentities(ucfirst($temp[2]));

			// Checking if the title and reason atleast contain a letter each.
			$this->validateInput($proposalTitle, $proposalReason);

			if ($proposalType == "proposeSecondary") 
			{
				$primarySubject = $temp[3];

				// Checking if it already exists
				if ($this->doesSecondaryProposalExist($proposalTitle, $primarySubject)) 
				{
					$this->dieWithAlert("alertError", "Proposal already exists");
				}

				// Saving the proposal to the db
				$this->saveSecondaryProposal($proposalTitle, $proposalReason, $primarySubject);
				return true;
			}
			elseif ($proposalType == "proposePrimary") 
			{
				// Checking if it already exists
				if ($this->doesPrimaryProposalExist($proposalTitle)) 
				{
					$this->dieWithAlert("alertError", "Proposal already exists");
				}

				// Saving the proposal to the db
				$this->savePrimaryProposal($proposalTitle, $proposalReason);
				return true;
			}
		}

		return false;
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
}
?>