<?php  
require_once("../Models/model.php");

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

		// Getting the values that we're send with the ajax request
		$subject = $_POST['data'];

		// Getting all secondary subjects which fall under the given primary subject
		$secondarySubjects = $this->getSecondarySubjects($subject);
		$previewPosts = $this->getPreviewPosts($secondarySubjects);
		// Putting the primarysubject and secondary subjects in the returnData.
		$returnData["primarySubject"] = $subject;
		$returnData["secondarySubjects"] = $secondarySubjects;
		$returnData["previewPosts"] = $previewPosts;

		return $returnData;
	}

	/**
	 * Function gets all the secondary subjects which fall under the given primary subject
	 * 
	 * @param primary subject
	 * @return array containing all secondary subjects
	 */
	private function getSecondarySubjects($subject) 
	{
		$dbConn = $this->openDBConnection();
		$dbOutput = [];
		$secondarySubjects = [];

		try 
		{
			$stmt = $dbConn->prepare("SELECT * FROM subjects WHERE PrimarySubject = ?");
			$stmt->execute([$subject]);
			$dbOutput =	 $stmt->fetchAll();
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		$this->closeDBConnection($dbConn);

		// Since the db output is a nested loop we have to filter out the stuff we dont need 
		for ($i = 0; $i < count($dbOutput); $i++) 
		{
			$currArray = $dbOutput[$i];
			array_push($secondarySubjects, $currArray["SecondarySubject"]);
		}

		return $secondarySubjects;
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
		$dbConn = $this->openDBConnection();
		$dbOutput = [];

		try 
		{
			$stmt = $dbConn->prepare("SELECT posts.*, users.userName FROM `posts` INNER JOIN `users` ON posts.postCreatorID = users.userID WHERE SecondarySubject = ? AND users.userID = posts.postCreatorID ORDER BY posts.postCreationDatetime DESC LIMIT $numOfPosts");
			$stmt->execute([$secondarySubject]);
			$dbOutput =	 $stmt->fetchAll();
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		$this->closeDBConnection($dbConn);
		return $dbOutput;
	}
}
?>