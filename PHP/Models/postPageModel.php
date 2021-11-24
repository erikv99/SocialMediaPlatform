<?php  
require_once("model.php");

class PostPageModel extends Model 
{
	public function execute() : array
	{
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
		$buttonAction = "";

		// Checking if a 4th argument is given (only when the edit or delete button is pressed)
		if(isset($temp[3])) 
		{ 
			$buttonAction = $temp[3];
			if ($buttonAction != "")
			if ($buttonAction == "delete") 
			{
				// Delete the post
			}

			// 1. is user logged in? no then go back.
			// 2. is user id same as creator of post id? no then go back
			// 3. Return editable view.
		}
		unset($temp);

		// Getting the json array containing all the data of that post.
		$postData = $this->getPostData($postID);
		$returnData["postData"] = $postData;

		// setting the buttonAction for the view
		$returnData["buttonAction"] = $buttonAction;

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
		$dbConn = $this->openDBConnection();
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

		$this->closeDBConnection($dbConn);
		return $dbOutput;
	}

	/**
	 * Figures out which viewtype we want to request for the view. 
	 * 
	 * the options are:
	 * normal : does not include a edit or delete button in the header
	 * owner : user == post owner, includes a edit and delete button
	 * edit : view which gives user the option to edit the post.
	 *
	 * @return string $viewType
	 */
	private function getViewType()
	{

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


}
?>