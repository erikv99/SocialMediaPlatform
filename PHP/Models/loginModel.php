<?php 

require_once("../Models/model.php");

class LoginModel extends Model 
{
	public function __construct()
	{

	}

	public function execute() : array 
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

		// If either the password is incorrect or the username doesnt exist we pass the same message to not disclose valuable information.
		if (!$this->usernameExists($username) OR !$this->isPasswordCorrect($username, $password)) 
		{	
			$returnData["message"] = "Username or password incorrect, please try again";
			$returnData["messageType"] = "alertWarning";
			return $returnData;
		}

		// starting a session and loggin the user in
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['loggedIn'] = true;


		// If everthing is well we only want the alert to be returned, not the login itself.
		$returnData["getAlertOnly"] = true;
		$returnData["message"] = "Login succesfull";
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
		$passwordCorrect = password_verify($password, $hashedPassword);
		return $passwordCorrect;
	}
}

?>