<?php 

require_once("../generalFunctions.php");
require_once("../Exceptions/databaseException.php");

/** Model base class */
class Model
{


	public function __construct(){}

	/**
	 * Function which will execute the logic inside the model class.
	 * 
	 */
	public function execute() 
	{
		return [];
	}

	/**
	 * Function will open a db connection and return it
	 * 
	 * @return 
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
		$conn = null;
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

}
?>