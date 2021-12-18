<?php 

require_once("model.php");

class LoginModel extends Model 
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

		// If either the password is incorrect or the username doesnt exist we pass the same message to not disclose valuable information.
		if (!$this->usernameExists($username) OR !$this->isPasswordCorrect($username, $password)) 
		{	
			$returnData["message"] = "Username or password incorrect, please try again";
			$returnData["messageType"] = "alertWarning";
			return $returnData;
		}

		// Checking if the user is a admin or not
		$userIsAdmin = $this->userIsAdminCheck($username);

		// loggin the user in in the session
		$_SESSION['username'] = $username;
		
		$_SESSION['loggedIn'] = true;
		
		// If everthing is well we only want the alert to be returned, not the view itself.
		$this->dieWithAlert("alertSuccess", "Login succesful", false);
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
		$dbConn = openDBConnection();
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
			throw new DBException($e->getMessage());
		}

		closeDBConnection($dbConn);
		$hashDBpass = password_hash($password, PASSWORD_DEFAULT);

		// Checking if the password matches the hashed version then returning the result.
		$passwordCorrect = password_verify($password, $hashedPassword);
		return $passwordCorrect;
	}

	/**
	 * Checks the db if the user is a admin. if so setting the session var (used in model::isUserAdmin)
	 * 
	 * @param string $username
	 */
	private function userIsAdminCheck(string $username) 
	{
		// Opening a DB connection and checking if the given username is present in our data table
		$dbConnection = openDBConnection();

		try 
		{
			$stmt = $dbConnection->prepare("SELECT isAdmin FROM users WHERE userName = ?");
			$stmt->execute([$username]);
			$output = $stmt->fetch()["isAdmin"];
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		// Checking if the db output for isAdmin is 1, if so returning true else returning false.
		$userIsAdmin = ($output == "1") ? true : false;
		$_SESSION['isAdmin'] = $userIsAdmin;

		// Closing the DB connection
		closeDBConnection($dbConnection);
	}
}

?>