<?php 

require_once("../Models/model.php");

class LoginModel extends Model 
{
	public function __construct()
	{
		$returnData = [];

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

		$returnData["getAlertOnly"] = true;
		$returnData["message"] = "Registry succesfull, you can now log in";
		$returnData["messageType"] = "alertSuccess";
		return $returnData;
	}

	/**
	 * Function checks if the entered password is the correct password for the given username
	 * 
	 * @param string $username
	 * @param string $password
	 * @return bool isPasswordCorrect
	 */
	private function isPasswordCorrect(string $username, string $password) : bool 
	{
		// Opening a DB connection
		$dbConn = $this->openDBConnection();

		$hashedPassword = "";

		// Getting the hashed password coresponding to the given username 
		try 
		{
			$stmt = $dbConn->prepare("SELECT password FROM users WHERE userName = ?");
			$stmt->execute([$username]);
			$hashedPassword = $stmt->fetch()["password"];
		}
		catch (PDOException $e) 
		{
			die("Database error, please check the log file.");
			logError("DATABASE ERROR: Error getting password from table users in database, function: isPasswordCorrect in file loginModel.php");
		}

		// Checking if the password matches the hashed version then returning the result.
		$passwordCorrect = password_verify($password, $hashedPassword)
		return $passwordCorrect;
	}
}

?>