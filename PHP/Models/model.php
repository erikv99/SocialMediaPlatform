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
	 * Function will open a db connection and return it
	 * 
	 * @return $openedDBConnection
	 */
	protected function openDBConnection()
	{ 
		$dbHost = "localhost";
		$dbUser = "root";
		$dbPass = "";
		$dbName = "thoughtshare";

		try 
		{
			$conn = new PDO("mysql:host=" . $dbHost . ";dbname=" . $dbName . ";", $dbUser, $dbPass);
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());	
		}

		return $conn;
	}

	/**
	 * Function for closing a existing database connection
	 * 
	 * @param open database connection (passed by reference)
	 */ 
	protected function closeDBConnection(&$conn)
	{	
		unset($conn);
	}

	/**
	 * Function to check if the given username is already present in the user table in the database
	 * function is placed in the model base since it is used more then once
	 * 
	 * @return bool doesUserExist
	 */
	protected function usernameExists(string $username) 
	{
		// Opening a DB connection and checking if the given username is present in our data table
		$dbConnection = $this->openDBConnection();

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
		$this->closeDBConnection($dbConnection);
		return $doesUserExist;
	}

	/**
	 * Function which checks if the data variable in the post request is empty or not. 
	 */
	protected function isPostDataEmpty() 
	{
		$returnVal = $_POST["data"] == "" ? true : false;
		return $returnVal;
	}

	protected function isPostFormDataEmpty() 
	{
		$returnVal = !isset($_POST["username"]) ? true : false;
		logDebug("returnval isPostFormDataEmpty: " . var_export($returnVal, true));
		return $returnVal;
	}

}
?>