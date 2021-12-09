<?php  
require_once("model.php");

class PrimarySubjectModel extends Model
{
	public function __construct() {}

	public function execute() : array 
	{
		$returnData = [];

		// Getting the values that we're send with the ajax request
		$subject = $_POST['data'];

		// Setting the data needed for the locationBar
		$returnData["locations"] = [$subject => "callController('.content', 'primarySubjectController', '$subject')",];

		// Getting all secondary subjects which fall under the given primary subject
		$secondarySubjects = $this->getSecondarySubjects($subject);
		$previewPosts = $this->getPreviewPosts($secondarySubjects);
		// Putting the primarysubject and secondary subjects in the returnData.
		$returnData["primarySubject"] = $subject;
		$returnData["secondarySubjects"] = $secondarySubjects;
		$returnData["previewPosts"] = $previewPosts;

		return $returnData;
	}

	private function getPreviewPosts(array $secondarySubjects) : array
	{
		// Will return a 3 level deep array. level 1 = secondary subjects, level 2 = posts (index), level 3 = postinfo (name title etc)
		$postPreviews = [];

		// Looping thru all the secondary subjects
		for ($i = 0; $i < count($secondarySubjects); $i++) 
		{
			// Getting the last x posts for the current secondary subjects
			$lastXPosts = $this->getLastXPosts(3, $secondarySubjects[$i]);

			$postPreviews[$secondarySubjects[$i]] = $lastXPosts;

		}

		return $postPreviews;
	}

	private function getLastXPosts(int $numOfPosts, string $secondarySubject) : array
	{
		$dbConn = openDBConnection();
		$dbOutput = [];

		try 
		{
			$stmt = $dbConn->prepare("SELECT * FROM `posts` WHERE SecondarySubject = ? ORDER BY postCreationDatetime DESC LIMIT $numOfPosts");
			$stmt->execute([$secondarySubject]);
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