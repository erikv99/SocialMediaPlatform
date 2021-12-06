<?php  
require_once("model.php");

class CreatePostModel extends Model 
{
	public function execute() : array 
	{
		$returnData = [];

		// Checking if the post var is empty or not. 
		if ($this->isPostDataEmpty())
		{
			return $returnData;
		}

		// Checking if user is logged in, else returning with a alert informing the user
		if (!isUserLoggedIn()) 
		{
			echo json_encode(["view" => "<script type='text/javascript'>callController(\".page\", \"alertController\", {\"alertType\":\"alertInfo\",\"alertMessage\":\"Must be logged in to create a new post\"});</script>"]);
			die();
		}

		// Getting the primary and secondary subjects from the data given
		$temp = explode(",", $_POST['data']);
		$primarySubject = $temp[0];
		$secondarySubject = $temp[1];

		// Setting the subjects since they are needed in the view when calling this function again for saving. basically this would be some form of recursion i guess.
		$returnData["primarySubject"] = $primarySubject;
		$returnData["secondarySubject"] = $secondarySubject;

		// checking if the $temp[2] exists, then checking if the arg is create.
		if (isset($temp[2])) 
		{
			// Just a little bit of extra verification, not really needed but whatever.
			if ($temp[2] == "create") 
			{
				$this->createNewPost($temp);

			}
		}
		// Setting the locations for the locationsbar
		$returnData["locations"] = 
		[
			$primarySubject => "callController('.content', 'primarySubjectController', '$primarySubject')",
			$secondarySubject => "callController('.content', 'secondarySubjectController', '$primarySubject,$secondarySubject')",
			"Create post" => "callController('.content', 'createPostController', '$primarySubject,$secondarySubject')"
		];
	
		return $returnData;
	}

	/**
	 * Actually creates the new post inside the DB. 
	 * 
	 * Since a check if the user is logged in was performed earlier we wont do it again here.
	 * 
	 * @param array $temp
	 */
	private function createNewPost(array $temp)  
	{
		$postCreator = $_SESSION['username'];
		$currentDate = new DateTime();
		$currentDate = $currentDate->format('Y-m-d H:i:s');
		$dbConn = openDBConnection();
		$postTitle = ucfirst($temp[3]);
		$postContent = $temp[4];
		$primarySubject = $temp[0];
		$secondarySubject = $temp[1];

		// Checking if the title or content isn't empty
		$this->validateInput($postTitle, $postContent);

		// Creating a new post
		try
		{
			$stmt = $dbConn->prepare("INSERT INTO posts (postCreator, postCreationDatetime, postTitle, postContent, PrimarySubject, SecondarySubject) VALUES (?, ?, ?, ?, ?, ?)");
			$stmt->execute([$postCreator, $currentDate, $postTitle, $postContent, $primarySubject, $secondarySubject]);
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		// Getting the new post ID to show it to the user.
		try
		{
			$stmt = $dbConn->prepare("SELECT postID FROM posts WHERE postCreationDatetime = ? AND postCreator = ?");
			$stmt->execute([$currentDate, $postCreator]);
			$dbOutput = $stmt->fetch();
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		$postID = $dbOutput["postID"];
		closeDBConnection($dbConn);
		
		// Displaying the just created post by calling the postcontroller. 
		echo json_encode(["view" => "<script type='text/javascript'>callController('.content', 'postPageController', '$primarySubject,$secondarySubject,$postID');</script>"]);
		die();
	}

	/**
	 * Checks if the title and content input has atleast 1 char each.
	 * 
	 * @param string $title
	 * @param string $content
	 */
	private function validateInput(string $title, string $content) 
	{
		// Checking if the title contains atleast 1 normal letter
		if (!preg_match('/[A-Za-z]/', $title))
		{
			echo json_encode(["view" => "<script type='text/javascript'>callController(\".page\", \"alertController\", {\"alertType\":\"alertError\",\"alertMessage\":\"Title must atleast contain 1 letter\"});</script>"]);
			die();
		}

		// Checking if the content contains atleast 1 normal letter
		if (!preg_match('/[A-Za-z]/', $content))
		{
			echo json_encode(["view" => "<script type='text/javascript'>callController(\".page\", \"alertController\", {\"alertType\":\"alertError\",\"alertMessage\":\"Content must atleast contain 1 letter\"});</script>"]);
			die();
		}


	}
}
?>