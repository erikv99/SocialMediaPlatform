<?php  
require_once("../Models/model.php");

class SubjectPageModel extends Model
{
	public function __construct() {}

	public function execute() : array 
	{
		$returnData = [];

		// Checking if the post var is empty or not. 
		if (empty($_POST))
		{
			throw new CustomException("$_POST variable is empty");
			return $returnData;
		}

		// Getting the values that we're send with the ajax request
		$subject = $_POST['data'];
		
		// Getting all secondary subjects which fall under the given primary subject
		$secondarySubjects = $this->getSecondarySubjects($subject);


		logDebug(var_export($secondarySubjects), true);
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
			$stmt = $dbConn->prepare("SELECT * FROM `subjects` WHERE `PrimarySubject` = ?");
			$stmt->execute([$subject]);
			$dbOutput = $stmt->fetchAll();
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		logDebug("we reach this");
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