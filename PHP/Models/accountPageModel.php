<?php  
require_once("model.php");

class AccountPageModel extends Model 
{
	public function execute() : array 
	{
		$returnData = [];
		$returnData["viewType"] = "normal";

		// Getting the username from the argument
		$username = $_POST["data"];

		// Checking if the user is the same as the person who's account page was requested
		if ($this->userOwnsAccountPage($username)) 
		{
			$returnData["viewType"] = "owner";
		}		

		// Setting the locations for the locationsbar
		$returnData["locations"] = 
		[
			"User: " . $username => "callController('.content', 'AccountPageModel', '$username')"
		];

		return $returnData;
	}

	// Checks if the current user owns the account page request
	private function userOwnsAccountPage(string $username) : bool 
	{
		// Checking if user is logged in or not
		if ($this->isUserLoggedIn()) 
		{
			// Checking if the current user is the same as $username
			if ($username == $_SESSION['username']) 
			{
				return true;
			}
		}
		return false;

	}
}
?>