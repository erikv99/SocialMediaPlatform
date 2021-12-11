<?php 

require_once("../generalFunctions.php");
require_once("../Exceptions/databaseException.php");
require_once("../Exceptions/customException.php");

/** Model base class */
abstract class Model
{
	// This functions executes the model logic.
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
			// Getting all primary and secondary subjects
			$stmt = $dbConn->prepare("SELECT DISTINCT(`PrimarySubject`) FROM `posts`");
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
			$stmt = $dbConn->prepare("SELECT SecondarySubject FROM subjects WHERE PrimarySubject = ?");
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
}
?>