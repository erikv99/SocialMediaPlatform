<?php  
require_once("model.php");

class PostPageModel extends Model 
{
	public function execute() : array
	{
		/** the viewType options which can be returned are:
 		* normal : does not include a edit or delete button in the header
 		* owner : user == post owner, includes a edit and delete button
 		* edit : view which gives user the option to edit the post. (since user only sees edit/delete but if he owns the post no extra validation is needed)
		*/

		$returnData = [];

		// Checking if the post var is empty or not. 
		if ($this->isPostDataEmpty())
		{
			return $returnData;
		}

		// Splitting the post data on the comma to get the prim sub, sec sub and postID
		$temp = explode(",", $_POST['data']);
		$primarySubject = $temp[0];
		$secondarySubject = $temp[1];
		$postID = $temp[2];

		// Checking which button action is required if any.
		$buttonAction = $this->checkButtonAction($temp);
		
		// Unsetting the var since we dont need it anymore.
		unset($temp);

		// Getting the json array containing all the data of that post.
		$postData = $this->getPostData($postID);
		$returnData["postData"] = $postData;

		// Checking if the user is the owner of the post
		if ($this->isUserPostOwner($postData["userName"])) 
		{
			$returnData["viewType"] = "owner";
		}

		// If the button action is not none we check if it is delete or edit and execute the correct actions accordingly
		if ($buttonAction != "none") 
		{
			if ($buttonAction == "delete") 
			{
				// Deleting the post and redirecting the user to the secondary subject above it.
				$this->deletePostAndRedirect($postData, $primarySubject, $secondarySubject);
			}
			// This is only a else if for readability
			elseif ($buttonAction == "edit") 
			{
				$returnData["viewType"] = "edit";
			}
		}

			// 1. is user logged in? no then go back.
			// 2. is user id same as creator of post id? no then go back
			// 3. Return editable view.

		// Setting the locations for the locationsbar
		$returnData["locations"] = 
		[
			$primarySubject => "callController('.content', 'primarySubjectController', '$primarySubject')",
			$secondarySubject => "callController('.content', 'secondarySubjectController', '$primarySubject,$secondarySubject')",
			"PostID: " . $postID => "callController('.content', 'postPageController', '$primarySubject,$secondarySubject,$postID')"
		];

		return $returnData;
	}

	/**
	 * Returns all the data matching the giving postID
	 * 
	 * @param $postID
	 * @return JSON arr $postData
	 */
	private function getPostData($postID) 
	{
		$dbConn = openDBConnection();
		$dbOutput = [];

		try
		{
			$stmt = $dbConn->prepare("SELECT posts.*, users.userName FROM `posts` INNER JOIN `users` ON posts.postCreatorID = users.userID WHERE postID = ? AND users.userID = posts.postCreatorID ORDER BY posts.postCreationDatetime");
			$stmt->execute([$postID]);
			$dbOutput = $stmt->fetch();
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		closeDBConnection($dbConn);
		return $dbOutput;
	}

	/**
	 * Figures out if a button action has been given, if so it set the right actions in motion
	 * 
	 * @param array $splitResult 
	 */
	private function checkButtonAction (array $splitResult)
	{
		// Checking if a 4th argument is given returning otherwise. (only given when the edit or delete button is pressed)
		if(!isset($splitResult[3])) 
		{
			return "none";
		}

		switch($splitResult[3])
		{
			case "delete":
				return "delete";
				break;
			case "edit":
				return "edit";
				break;
			default:
				return "none";
				break;
		}
	}

	/**
	 * Checks if user is logged in and if username matches creator of post. (usernames are unique)
	 * 
	 * @param string $postOwner
	 * @return bool $isPostOwner
	 */
	private function isUserPostOwner(string $postOwner) 
	{
		session_start();

		// returning if the session var loggedIn is not set
		if (!isset($_SESSION["loggedIn"])) { return false; }

		// returning if the user isnt logged in
		if ($_SESSION["loggedIn"] == false) { return false; } 

		// returning if the username is not set
		if (!isset($_SESSION["username"])) { return false; }

		// Checking if the username matches the postCreator username. (usernames are unique so no need to use ID)
		$isPostOwner = $_SESSION["username"] == $postOwner ? true : false;
		return $isPostOwner;
	}

	/**
	 * Deletes the post from DB and redirects the user back to the upperlaying secondarysubject.
	 * 
	 * @param array $postData
	 */
	private function deletePostAndRedirect($postData, $primarySubject, $secondarySubject) 
	{
		// Making a post obj using the postdata, then deleting it
		$post = new Post($postData);
		$post->delete();

		// Stopping	the code and giving back JS that will call the secondarySubjectController and redirect the user to the secondarysubject that the just deleted post was in
		echo json_encode(["view" => "<script type='text/javascript'>callController('.content', 'secondarySubjectController', '$primarySubject,$secondarySubject');</script>"]);
		die();
	}
}
?>