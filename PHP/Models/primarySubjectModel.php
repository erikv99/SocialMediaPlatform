<?php  
require_once("model.php");

/** specific model class for the primary subject */
class PrimarySubjectModel extends Model
{
	/** 
	 * Executes the logic required for the specific model, sets any needed output and returns it.
	 * 
	 * @return array $output
	 */
	public function execute() : array 
	{
		$returnData = [];

		// Getting the values that we're send with the ajax request
		$primarySubject = $_POST['data'];

		// Setting the data needed for the locationBar
		$returnData["locations"] = [$primarySubject => "callController('.content', 'primarySubjectController', '$primarySubject')",];

		// Getting all secondary subjects which fall under the given primary subject
		$secondarySubjects = $this->getSecondarySubjects($primarySubject);
		$previewPosts = $this->getPreviewPosts($secondarySubjects, $primarySubject);

		// Putting the primarysubject and secondary subjects in the returnData.
		$returnData["primarySubject"] = $primarySubject;
		$returnData["secondarySubjects"] = $secondarySubjects;
		$returnData["previewPosts"] = $previewPosts;

		return $returnData;
	}

	/**
	 * Will get the the posts to preview data for each secondarysubject under the primary subject
	 * 
	 * @param array $secondarySubjects
	 * @param string $primarySubject
	 * @return array $postpreviews
	 */
	private function getPreviewPosts(array $secondarySubjects, string $primarySubject) : array
	{
		// Will return a 3 level deep array. level 1 = secondary subjects, level 2 = posts (index), level 3 = postinfo (name title etc)
		$postPreviews = [];

		// Looping thru all the secondary subjects
		for ($i = 0; $i < count($secondarySubjects); $i++) 
		{
			// Getting the last x posts for the current secondary subjects
			$lastXPosts = $this->getLastXPosts(3, $secondarySubjects[$i], $primarySubject);

			$postPreviews[$secondarySubjects[$i]] = $lastXPosts;

		}

		return $postPreviews;
	}

	/**
	 * Will return the last x ($numOfPosts) posts of the given secondary subject.
	 * 
	 * @param int $numOfPosts
	 * @param string $secondarySubject
	 * @param string $primarySubject
	 * @return array $lastXPosts
	 */
	private function getLastXPosts(int $numOfPosts, string $secondarySubject, string $primarySubject) : array
	{
		$dbConn = openDBConnection();
		$dbOutput = [];

		try 
		{
			$stmt = $dbConn->prepare("SELECT * FROM `posts` WHERE SecondarySubject = ? AND PrimarySubject = ? ORDER BY postCreationDatetime DESC LIMIT $numOfPosts");
			$stmt->execute([$secondarySubject, $primarySubject]);
			$dbOutput =	 $stmt->fetchAll();
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		closeDBConnection($dbConn);
		return $dbOutput;
	}
}
?>