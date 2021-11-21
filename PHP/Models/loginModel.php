<?php 

require_once("model.php");

class LoginModel extends Model 
{
	public function __construct() {}

	public function execute() : array 
	{
		$returnData = [];
		
		// Making sure we're not getting a extra location bar
		$returnData["locations"] = ["noLocationBar" => true,];

		// If the form is empty we dont want to continue
		if ($this->isPostFormDataEmpty())
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

		// If everthing is well we only want the alert to be returned, not the view itself.
		$this->returnAlertOnly("alertSuccess", "Login succesful");
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
			throw new DBException($e->getMessage());
		}

		$this->closeDBConnection($dbConn);

		// Checking if the password matches the hashed version then returning the result.
		$passwordCorrect = password_verify($password, $hashedPassword);
		return $passwordCorrect;
	}
}

?>