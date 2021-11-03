<?php 
require_once("../Views/registerView.php");
require_once("../Models/model.php");
require_once("../generalFunctions.php");
class RegisterModel extends Model  
{
	public function __construct() 
	{
		
	}

	public function execute() : array
	{
		$returnData = ["message" => ""];

		// If the form is empty we dont want to continue
		if (empty($_POST))
		{
			return $returnData;
		}

		// Getting the values from the form
		$username = $_POST["username"];
		$password = $_POST["password"];
		$confirmPassword = $_POST["confirmPassword"];

		// Checking if given password and confirmpassword match
		if ($password != $confirmPassword) 
		{

			$returnData["message"] = "Passwords do not match";
			$returnData["messageType"] = "alertDanger";
			return $returnData;
		}

		// Checking if the given username already exists
		if ($this->usernameExists($username)) 
		{
			$returnData["message"] = "Username is taken, please try again";
			$returnData["messageType"] = "alertDanger";
			return $returnData;
		}

		// Creating our new user in the database
		$this->createUser($username, $password);

		$returnData["message"] = "Shit should be good";
		$returnData["messageType"] = "alertInfo";
		return $returnData;
	}

	/**
	 * Function to check if the given username is already present in the user table in the database
	 * 
	 * @return bool doesUserExist
	 */
	private function usernameExists(string $username) 
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
			die("<br>Error checking if user exists in database: " . $e->getMessage());
		}


		// If the username is present $doesUserExist will be true otherwise it shall be false.
		$doesUserExist = ($output > 0) ? true : false;

		// Closing the DB connection and returning the result
		$this->closeDBConnection($dbConnection);
		return $doesUserExist;
	}

	/**
	 * Function which will create a new user in the database
	 * 
	 * @param string $username
	 * @param string $password
	 */
	private function createUser(string $username, string $password) 
	{
		// Checking if the username already exists in the database (this is checked before but just for safety done again here since this function relies on the user not existing yet)
		if ($this->usernameExists($username)) 
		{
			die("Function createUser was given a username which already exists. please call usernameExists() and validate before creating a new user.");
		}

		// Opening a db connection and adding the user to the database
		$dbConnection = $this->openDBConnection();

		try 
		{
			$stmt = $dbConnection->prepare("INSERT INTO users (userName, password, creationDate) VALUES (?, ?, now())");
			$stmt->execute([$username, $password]); 
		}
		catch (PDOException $e) 
		{
			die("<br>Error creating user in database: " . $e->getMessage());
		}

	}
}
?>