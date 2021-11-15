<?php 
require_once("../Models/model.php");

class RegisterModel extends Model  
{
	public function __construct() {}

	public function execute() : array
	{
		$returnData = [];
				
		if ($this->isPostFormDataEmpty()) 
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

		$returnData["getAlertOnly"] = true;
		$returnData["message"] = "Registry succesfull, you can now log in";
		$returnData["messageType"] = "alertSuccess";
		return $returnData;
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

		// Hashing the password
		$hashedPass = password_hash($password, PASSWORD_DEFAULT);

		try 
		{
			$stmt = $dbConnection->prepare("INSERT INTO users (userName, password, creationDate) VALUES (?, ?, now())");
			$stmt->execute([$username, $hashedPass]); 
		}
		catch (PDOException $e) 
		{
			die("<br>Error creating user in database: " . $e->getMessage());
		}

	}
}
?>