<?php 
require_once("model.php");

class RegisterModel extends Model  
{
	public function __construct() {}

	public function execute() : array
	{
		$returnData = [];

		if (!$this->isLoginDataSet()) 
		{ 
			return $returnData; 
		}

		// Making sure we're not getting a extra location bar
		$returnData["locations"] = ["noLocationBar" => true,];

		// Getting the values from the form
		$username = $_POST["username"];
		$password = $_POST["password"];
		$confirmPassword = $_POST["confirmPassword"];

		// Checking if given password and confirmpassword match
		if ($password != $confirmPassword) 
		{

			$returnData["message"] = "Passwords do not match";
			$returnData["messageType"] = "alertError";
			return $returnData;
		}

		// Checking if the given username already exists
		if ($this->usernameExists($username)) 
		{
			$returnData["message"] = "Username is taken, please try again";
			$returnData["messageType"] = "alertError";
			return $returnData;
		}

		// Creating our new user in the database
		$this->createUser($username, $password);

		// If everthing is well we only want the alert to be returned, not the view itself.
		$this->dieWithAlert("alertSuccess", "Registry succesful");
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
			logError("Function createUser was given a username which already exists. please call usernameExists() and validate before creating a new user.");
			die("Error: Refer to error.txt for information");
		}

		// Opening a db connection and adding the user to the database
		$dbConnection = openDBConnection();

		// Hashing the password
		$hashedPass = password_hash($password, PASSWORD_DEFAULT);

		try 
		{
			$stmt = $dbConnection->prepare("INSERT INTO users (username, password, creationDate) VALUES (?, ?, now())");
			$stmt->execute([$username, $hashedPass]); 
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		closeDBConnection($dbConnection);
	}
}
?>