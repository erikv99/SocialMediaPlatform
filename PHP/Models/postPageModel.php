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
		$returnData["viewType"] = "normal";
		
		// Getting the data from the request and putting it in variables for easier usage.
		$requestData = $this->getRequestData();
		$primarySubject = $requestData["primarySubject"];
		$secondarySubject = $requestData["secondarySubject"];
		$postID = $requestData["postID"];

		// Getting the json array containing all the data of that post.
		$postData = $this->getPostData($postID);
	
		$userIsAdmin = $this->isUserAdmin();
		$userIsPostOwner = $this->isUserPostOwner($postData["postCreator"]);

		// Checking if the user is the owner of the post or an admin
		if ($userIsPostOwner or $userIsAdmin) 
		{
			$returnData["viewType"] = "owner";
		}
		
		//  handeling any button action we might need to handle
		$output = $this->handleButtonAction($postData);

		// If handleButtonAction returned anything this will be the viewtype. (edit is the only option)
		if ($output != "") 
		{
			$returnData["viewType"] = $output;
		}

		// Unsetting the output and button action vars
		unset($output, $buttonAction);

		// Setting the postdata
		$returnData["postData"] = $postData;

		// Setting the locations for the locationsbar
		$returnData["locations"] = 
		[
			$primarySubject => "callController('.content', 'primarySubjectController', '$primarySubject')",
			$secondarySubject => "callController('.content', 'secondarySubjectController', '$primarySubject|$secondarySubject')",
			"PostID: " . $postID => "callController('.content', 'postPageController', '$primarySubject|$secondarySubject|$postID')"
		];

		return $returnData;
	}

	/**
	 * Will get and format the data from the post request
	 * 
	 * @return array $requestData
	 */
	private function getRequestData() 
	{
		// Splitting the string on the comma, assigning the vals to a array
		$temp = explode("|", $_POST['data']);
		$postRequestData["primarySubject"] = $temp[0];
		$postRequestData["secondarySubject"] = $temp[1];
		$postRequestData["postID"] = $temp[2];	
		return $postRequestData;
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
			$stmt = $dbConn->prepare("SELECT * FROM `posts` WHERE postID = ? ORDER BY postCreationDatetime");
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
	 * @param array $postData
	 * @return string $buttonAction
	 */
	private function handleButtonAction (array $postData)
	{
		// Getting the data from the post request splitted on each comma
		$splitResult = explode("|", $_POST['data']);
	
		// Checking if a 4th argument is given returning otherwise. (only given when the edit or delete button is pressed)
		if(!isset($splitResult[3])) 
		{
			return "";
		}

		switch($splitResult[3])
		{
			case "none":
				return;
				break;

			case "delete":
				// Deleting the post and redirecting the user to the secondary subject above it.
				$this->deletePostAndRedirect($postData);
				break;

			case "save": 
				$this->saveEditedPost($postData);
				break;

			case "edit":
				return "edit";
				break;
		}

		return "";
	}

	/**
	 * Checks if user is logged in and if username matches creator of post. (usernames are unique)
	 * 
	 * @param string $postOwner
	 * @return bool $isPostOwner
	 */
	private function isUserPostOwner(string $postOwner) 
	{
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
	private function deletePostAndRedirect($postData) 
	{
		// Making a post obj using the postdata, then deleting it
		$post = new Post($postData);
		$primarySubject = $postData["PrimarySubject"];
		$secondarySubject = $postData["SecondarySubject"];
		$post->delete();

		// Stopping	the code and giving back JS that will call the secondarySubjectController and redirect the user to the secondarysubject that the just deleted post was in
		echo json_encode(["view" => "<script type='text/javascript'>callController('.content', 'secondarySubjectController', '$primarySubject|$secondarySubject');</script>"]);
		die();
	}

	/** 
	 * Handles saving the edited content of the post.
	 * 
	 *	@param array $postData
	 */
	private function saveEditedPost($postData)
	{	
		// Making a post obj using the postdata
		$post = new Post($postData);

		// Getting data from the post request, 5th arg is the data from the textArea (updated content), no need for validation since this function only gets called if the 4th arg (button action) is save. which is only the case when the save button is pressed.
		$splitResult = explode("|", $_POST['data']);
		$editedContent = htmlentities($splitResult[4]);		

		// Checking if the editedContent contains atleast 1 letter using regex (dont want empty content) (checking length wont be enough since spaces count for the length as well.)
		if (!preg_match('/[A-Za-z]/', $editedContent))
		{
			$this->dieWithAlert("alertError", "Content must atleast contain 1 letter");
		}

		// Saving the updated content.
		$post->updateContent($editedContent);

		$primarySubject = $postData["PrimarySubject"];
		$secondarySubject = $postData["SecondarySubject"];
		$postID = $postData["postID"];

		// Stopping the code and calling the postPageController to refresh the post
		echo json_encode(["view" => "<script type='text/javascript'>callController('.content', 'postPageController', '$primarySubject|$secondarySubject|$postID');</script>"]);
		die();
	}
}
?>