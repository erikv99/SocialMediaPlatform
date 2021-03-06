<?php 

require_once("../generalFunctions.php");
require_once("../Exceptions/databaseException.php");
require_once("../Exceptions/customException.php");

/** Model base class */
abstract class Model
{
	/** 
	 * Executes the logic required for the specific model, sets any needed output and returns it.
	 * 
	 * @return array $output
	 */
	abstract protected function execute() : array;

	/**
	 * Function to check if the given username is already present in the user table in the database
	 * function is placed in the model base since it is used more then once
	 * 
	 * @return bool doesUserExist
	 */
	protected function usernameExists(string $username) : bool
	{
		// Opening a DB connection and checking if the given username is present in our data table
		$dbConnection = openDBConnection();

		try 
		{
			$stmt = $dbConnection->prepare("SELECT COUNT(userName) FROM users WHERE userName = ?");
			$stmt->execute([$username]);
			$output = $stmt->fetch()["COUNT(userName)"];
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());

		}

		// If the username is present $doesUserExist will be true otherwise it shall be false.
		$doesUserExist = ($output > 0) ? true : false;

		// Closing the DB connection and returning the result
		closeDBConnection($dbConnection);
		return $doesUserExist;
	}

	/**
	 * Checks if user is logged in or not.
	 * 
	 * @return bool $isLoggedIn
	 */
	protected function isUserLoggedIn() 
	{
		// Checking if the loggedIn session variable is set
		if (isset($_SESSION["loggedIn"]))
		{
		    // checking if it is set to true
		    if ($_SESSION["loggedIn"] == true) 
		    {
		        return true;
		    }
		}
    	return false;
	}

	/**
	 * Checks if the user is an admin or not
	 * 
	 * @return bool $isAdmin
	 */
	protected function isUserAdmin() : bool
	{	
		// Checking if the isAdmin var is set
		if (isset($_SESSION['isAdmin'])) 
		{
			// Checking if it is set to true
			if ($_SESSION['isAdmin'] == true) 
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * Function to get all primary subjects (no duplicates)
	 * 
	 * @return array $primarySubjects
	 */
	protected function getPrimarySubjects() : array
	{
		$dbConn = openDBConnection();
		$dbOutput = [];
		$primarySubjects = [];

		try
		{
			// Getting all primary subjects
			$stmt = $dbConn->prepare("SELECT DISTINCT(`PrimarySubject`) FROM `subjects`");
			$stmt->execute();
			$dbOutput = $stmt->fetchAll();
		}
		catch (PDOException $e)
		{
			throw new DBException($e->getMessage());
			
		}	

		closeDBConnection($conn);

		// Since the db output contains of arrays containing the primarysubject we're taking that apart real quick
		for ($i = 0; $i < count($dbOutput); $i++) 
		{
			array_push($primarySubjects, $dbOutput[$i][0]);
		}

		return $primarySubjects;
	}

	/**
	 * Function to get all secondarySubjects
	 * 
	 * @param $primarySubjects for which to get the secondarysubjects
	 * @return array containing all secondarySubjects for the given primary.
	 */
	protected function getSecondarySubjects($primarySubject) : array
	{
		$dbConn = openDBConnection();
		$dbOutput = [];	
		
		try
		{
			// Getting all secondary subjects for the current primary subject
			$stmt = $dbConn->prepare("SELECT SecondarySubject FROM subjects WHERE PrimarySubject = ? AND SecondarySubject IS NOT NULL");
			$stmt->execute([$primarySubject]);
			$dbOutput = $stmt->fetchAll();
		}
		catch (PDOException $e)
		{
			throw new DBException($e->getMessage());
		}	

		closeDBConnection($conn);

		$secondarySubjects = [];

		// Since the db output contains of array containing the secondarysubject(s) we unpack them here.
		for ($i = 0; $i < count($dbOutput); $i++) 
		{
			array_push($secondarySubjects, $dbOutput[$i][0]);
		}

		return $secondarySubjects;
	}

	/**
	 * Function to get all subjects (Key = primarySubject, value = array of secondary subjects)
	 * 
	 * @return array $subjects (key = primarySubject, value = array containing secondary subjects)
	 */
	protected function getSubjects() : array 
	{
		$subjects = [];

		// Getting all the primary subjects from the database
		$primarySubjects = $this->getPrimarySubjects();

		// Looping thru each primarySubject
		for ($i = 0; $i < count($primarySubjects); $i++) 
		{		

			$secondarySubjects = $this->getSecondarySubjects($primarySubjects[$i]);

			$subjects[$primarySubjects[$i]] = $secondarySubjects;
		}

		return $subjects;
	}

	/**
	 * Checks if the login data in the post is set.
	 * 
	 * @return bool $isLoginDataSet
	 */
	protected function isLoginDataSet() 
	{
		if (!isset($_POST["username"])) { return false; }
		if (!isset($_POST["password"])) { return false; }
		return true;
	}

	/**
	 * Will stop running the code and exit with a alert
	 * 
	 * @param string $alertType
	 * @param string $alertMessage
	 * @param bool $refreshPageBeforeAlert (optional)
	 */
	protected function dieWithAlert(string $alertType, string $alertMessage, bool $refreshPageBeforeAlert = false) 
	{	
		$refreshView = "";

		if ($refreshPageBeforeAlert) 
		{
			$refreshView = "refreshPage(); ";
		}
    	echo json_encode(["view" => "<script type='text/javascript'>$refreshView callController(\".page\", \"alertController\", {\"alertType\":\"$alertType\",\"alertMessage\":\"$alertMessage\"});</script>"]);
    	die();
	}

	/** 
	 * Function to give the a user a certain amount of credits, uses pdo transaction methods.
	 * 
	 * @param string $username
	 * @param int $credits
	 */
	protected function giveUserCredits(string $username, int $credits) 
	{
		// Checking if the amount of credits we're suppose to give is more then zero
		if ($credits < 1) 
		{
			logError("giveUserCredits arguments $credits can not be less then 1");
			return;
		} 

		$dbConn = openDBConnection();
		
		try
		{
			// Beginning the transaction
			$dbConn->beginTransaction();

			// updating the users amount of credits
			$stmt = $dbConn->prepare("UPDATE users SET credits = credits + ? WHERE username = ?");
			$stmt->execute([$credits, $username]);

			// If we reach this point without exceptions we will commit our change
			$dbConn->commit();
		}
		catch (PDOException $e)
		{
			// Rolling back the transaction.
			$dbConn->rollback();
			throw new DBException($e->getMessage());
		}	

		closeDBConnection($conn);

	}

	/**
	 * Function which will return the amount of credits a user owns
	 *
	 * @param string $username
	 * @return $credits
	 */
	protected function getUserCreditBalance(string $username) 
	{
		$dbConn = openDBConnection();
		$dbOutput = [];

		try
		{
			// getting the amount of credits of the user
			$stmt = $dbConn->prepare("SELECT credits FROM users WHERE username = ?");
			$stmt->execute([$username]);
			$dbOutput = $stmt->fetch()["credits"];
		}
		catch (PDOException $e)
		{
			throw new DBException($e->getMessage());
		}	

		closeDBConnection($conn);
		return $dbOutput;
	}
}
?>