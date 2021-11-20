<?php  
require_once("model.php");

class ContentModel extends Model 
{
	public function __construct() {}

	public function execute() : array 
	{
		$returnData = [];
		
		// Getting the subjects array (key = primarySubject value = arrray of secondary subjects)
		$subjects = $this->getSubjects();

		$returnData["subjects"] = $subjects;	
		return $returnData;
	}

	/**
	 * Function to get all primary subjects (no duplicates)
	 * 
	 * @return array $primarySubjects
	 */
	private function getPrimarySubjects() : array
	{
		$dbConn = $this->openDBConnection();
		$dbOutput = [];
		$primarySubjects = [];

		try
		{
			// Getting all primary and secondary subjects
			$stmt = $dbConn->prepare("SELECT DISTINCT(`PrimarySubject`) FROM `posts`");
			$stmt->execute();
			$dbOutput = $stmt->fetchAll();
		}
		catch (PDOException $e)
		{
			throw new DBException($e->getMessage());
			
		}	

		$this->closeDBConnection($conn);

		// Since the db output contains of arrays containing the primarysubject we're taking that apart real quick
		for ($i = 0; $i < count($dbOutput); $i++) 
		{
			array_push($primarySubjects, $dbOutput[$i][0]);
		}

		return $primarySubjects;
	}

	/**
	 * Function to get all subjects (Key = primarySubject, value = array of secondary subjects)
	 * 
	 * @return array $subjects (key = primarySubject, value = array containing secondary subjects)
	 */
	private function getSubjects() : array 
	{
		$subjects = [];

		// Getting all the primary subjects from the database
		$primarySubjects = $this->getPrimarySubjects();

		// Looping thru each primarySubject
		for ($i = 0; $i < count($primarySubjects); $i++) 
		{		

			$secondarySubjects = $this->getSecondarySubjects($primarySubjects[$i]);

			$subjects[$primarySubjects[$i]] = $secondarySubjects;
		}

		return $subjects;
	}

	/**
	 * Function to get all secondarySubjects
	 * 
	 * @param $primarySubjects for which to get the secondarysubjects
	 * @return array containing all secondarySubjects for the given primary.
	 */
	private function getSecondarySubjects($primarySubject) : array
	{
		$dbConn = $this->openDBConnection();
		$dbOutput = [];	
		
		try
		{
			// Getting all secondary subjects for the current primary subject
			$stmt = $dbConn->prepare("SELECT SecondarySubject FROM subjects WHERE PrimarySubject = ?");
			$stmt->execute([$primarySubject]);
			$dbOutput = $stmt->fetchAll();
		}
		catch (PDOException $e)
		{
			throw new DBException($e->getMessage());
		}	

		$this->closeDBConnection($conn);

		$secondarySubjects = [];

		// Since the db output contains of array containing the secondarysubject(s) we unpack them here.
		for ($i = 0; $i < count($dbOutput); $i++) 
		{
			array_push($secondarySubjects, $dbOutput[$i][0]);
		}

		return $secondarySubjects;

	}
}


?>