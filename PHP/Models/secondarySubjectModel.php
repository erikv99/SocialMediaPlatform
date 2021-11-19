<?php  
require_once("model.php");

class PrimarySubjectModel extends Model
{
	public function __construct() {}

	public function execute() : array 
	{
		$returnData = [];

		// Checking if the post var is empty or not. 
		if ($this->isPostDataEmpty())
		{
			return $returnData;
		}

		// Splitting the post data on the comma to get both the primary and secondary subject
		$temp = explode(",", $_POST['data']);
		$primarySubject = $temp[0];
		$secondarySubject = $temp[1];
		unset($temp);

		// Setting the data needed for the locationBar
		$returnData["locations"] = 
		[
			$subject => "callController('.content', 'PrimarySubjectController', '$primarySubject')",
			$secondarySubject => "callController('.content', 'SecondarySubjectController', '$secondarySubject')"
		];

		// Getting the last x posts to preview.
		$previewPosts = $this->getPosts($secondarySubject);
		logDebug("previewPosts: " . var_export($previewPosts, true));
		// Putting the primarysubject and secondary subjects in the returnData.
		$returnData["primarySubject"] = $subject;
		$returnData["secondarySubjects"] = $secondarySubjects;
		$returnData["previewPosts"] = $previewPosts;

		return $returnData;
	}

	/**
	 * Gets all the posts for this secondarySubject
	 * 
	 * @param string $secondarySubject
	 * @return array $posts ordered by creation date (newest first)
	 */
	private function getPosts($secondarySubject) 
	{
		$posts = [];

		try 
		{
			$stmt = $dbConn->prepare("SELECT posts.*, users.userName FROM `posts` INNER JOIN `users` ON posts.postCreatorID = users.userID WHERE SecondarySubject = ? AND users.userID = posts.postCreatorID ORDER BY posts.postCreationDatetime");
			$stmt->execute([$secondarySubject]);
			$posts = $stmt->fetchAll();
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		$this->closeDBConnection($dbConn);
		return $posts;
	}
}
?>