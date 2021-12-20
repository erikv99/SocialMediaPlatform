<?php  
require_once("model.php");

/** specific model class for the account page */
class AccountPageModel extends Model 
{
	/** 
	 * Executes the logic required for the specific model, sets any needed output and returns it.
	 * 
	 * @return array $output
	 */
	public function execute() : array 
	{
		$returnData = [];
		$returnData["viewType"] = "normal";

		// Getting the username from the argument
		$username = $_POST["data"];

		// Sometimes we have to still get the username from the session var.
		if ($username == "currentUser") 
		{
			$username = $_SESSION["username"];
		}

		$returnData["username"] = $username;

		// Checking if the user is the same as the person who's account page was requested
		if ($this->userOwnsAccountPage($username)) 
		{
			$returnData["viewType"] = "owner";
		}		

		// Getting the amount of posts created by this user
		$returnData["amountOfPosts"] = $this->getAmountOfPostsCreated($username);

		// Getting the account creationdate
		$returnData["creationDate"] = $this->getAccountCreationDate($username);

		// Getting the amount of credits a user owns
		$returnData["creditBalance"] = $this->getUserCreditBalance($username);

		// Setting the locations for the locationsbar
		$returnData["locations"] = 
		[
			"User: " . $username => "callController('.content', 'AccountPageModel', '$username')"
		];

		return $returnData;
	}

	/** 
	 * Checks if the current user owns the account page request
	 * 
	 * @param string $username
	 * @return bool $userOwnsAccountPage
	 */
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

	/**
	 * returns the amount of posts created by the given username
	 * 
	 * @param string $username
	 * @return string $amountOfPostsCreated
	 */
	private function getAmountOfPostsCreated(string $username) 
	{
		// Opening a DB connection
		$dbConnection = openDBConnection();

		try 
		{
			$stmt = $dbConnection->prepare("SELECT COUNT(postID) FROM posts WHERE postCreator = ?");
			$stmt->execute([$username]);
			$output = $stmt->fetch()["COUNT(postID)"];
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		// Closing the DB connection and returning the result
		closeDBConnection($dbConnection);
		return $output;
	}

	/**
	 * Returns the formatted creation date of the account.
	 * 
	 * @param string $username
	 * @return string $creationDate
	 */
	private function getAccountCreationDate(string $username) 
	{
		// Opening a DB connection
		$dbConnection = openDBConnection();

		try 
		{
			$stmt = $dbConnection->prepare("SELECT creationDate FROM users WHERE username = ?");
			$stmt->execute([$username]);
			$output = $stmt->fetch()["creationDate"];
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		$creationDate = date_format(date_create($output), "d-m-Y");

		// Closing the DB connection and returning the result
		closeDBConnection($dbConnection);
		return $creationDate;
	}
}
?>