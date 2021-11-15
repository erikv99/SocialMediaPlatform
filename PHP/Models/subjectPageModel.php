<?php  
require_once("../Models/model.php");

class SubjectPageModel extends Model
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

		// Putting the primarysubject and secondary subjects in the returnData.
		$returnData["primarySubject"] = $subject;
		$returnData["secondarySubjects"] = $secondarySubjects;

		logDebug(var_export($secondarySubjects, true));
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
			logDebug("do we reach this: yes");
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		$this->closeDBConnection($dbConn);

		logDebug("dboutput: " . var_export($dbOutput, true));
		// Since the db output is a nested loop we have to filter out the stuff we dont need 
		for ($i = 0; $i < count($dbOutput); $i++) 
		{
			$currArray = $dbOutput[$i];
			logDebug("currArray: " . var_export($currArray["SecondarySubject"], true));
			array_push($secondarySubjects, $currArray["SecondarySubject"]);
		}
		logDebug("after loop");

		logDebug("secondarySubjects subjectpagemodel: " . var_export($secondarySubjects, true));
		return $secondarySubjects;
	}
}
?>