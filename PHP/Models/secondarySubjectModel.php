<?php  
require_once("model.php");

/** specific model class for the secondary subject */
class SecondarySubjectModel extends Model
{
	/** 
	 * Executes the logic required for the specific model, sets any needed output and returns it.
	 * 
	 * @return array $output
	 */
	public function execute() : array 
	{
		$returnData = [];

		// Splitting the post data on the comma to get both the primary and secondary subject
		$temp = explode("|", $_POST['data']);
		$primarySubject = $temp[0];
		$secondarySubject = $temp[1];
		unset($temp);

		// Setting the data needed for the locationBar
		$returnData["locations"] = 
		[
			$primarySubject => "callController('.content', 'PrimarySubjectController', '$primarySubject')",
			$secondarySubject => "callController('.content', 'SecondarySubjectController', '$primarySubject|$secondarySubject')"
		];

		// Getting the last x posts to preview.
		$previewPosts = $this->getPosts($secondarySubject, $primarySubject);
		
		// Putting the primarysubject and secondary subjects in the returnData.
		$returnData["primarySubject"] = $primarySubject;
		$returnData["secondarySubject"] = $secondarySubject;
		$returnData["previewPosts"] = $previewPosts;

		return $returnData;
	}

	/**
	 * Gets all the posts for this secondarySubject
	 * 
	 * @param string $secondarySubject
	 * @param string $pimarySubject
	 * @return array $posts ordered by creation date (newest first)
	 */
	private function getPosts(string $secondarySubject, string $primarySubject) 
	{
		$posts = [];
		$dbConn = openDBConnection();
		try 
		{
			$stmt = $dbConn->prepare("SELECT * FROM `posts` WHERE SecondarySubject = ? AND PrimarySubject = ? ORDER BY postCreationDatetime");
			$stmt->execute([$secondarySubject, $primarySubject]);
			$posts = $stmt->fetchAll();
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		closeDBConnection($dbConn);
		return $posts;
	}
}
?>