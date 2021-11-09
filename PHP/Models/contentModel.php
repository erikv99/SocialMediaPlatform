<?php  
require_once("../Models/model.php");

class ContentModel extends Model 
{
	public function __construct() {}

	public function execute() : array 
	{
		$returnData = [];

		// Get all subjects with their sub-subject.
		$dbConn = $this->openDBConnection();
		$dbResult = [];

		try
		{
			// Getting all primary and secondary subjects
			$stmt = $dbConn->prepare("SELECT * FROM `subjects`");
			$stmt->execute();
			$dbResult = $stmt->fetchAll();
		}
		catch (PDOException $e)
		{
			logError("DATABASE ERROR: Error getting primarysubjects in function execute of file contentModel.php");
			logError($e->getMessage());
			die("Database error, please check the log file.");
		}

		// Getting all primary subjects from our dbResults and putting them in a seperate array
		$arrayKeys = [];

		for ($i = 0; $i < count($dbResult); $i++) 
		{
			// Since each index is a array in itself we put it in a var first
			$currArray = $dbResult[$i];
	
			// Getting the primary key and adding it to our primaryKeys array.
			$currPrimaryKey = $currArray["PrimarySubject"];
			array_push($arrayKeys, $currPrimaryKey);
		}

		// Looping thru all the primary/secondy key value pairs and organizing them in a array for later use
		$subjects = $this->getSecondarySubjects($arrayKeys, $dbResult);
		
		$returnData["subjects"] = $subjects;	
		return $returnData;
	}

	/**
	* Gets all secondarySubjects per primarysubject
	* NOTE: This solution might be too slow if a massive amount of primary / secondary subjects exists. i think it does just fine for now.
	* NOTE
	* @param array of primary subject keys
	* @param array of all subjects (primary and secondary)
	* @return a array containing primarysubjects as keys and arrays of secondarysubjects as values
	*/
	private function getSecondarySubjects ($primarySubjectKeys, $allSubjects) 
	{

		$secondarySubjects = [];

		// Looping through all primarySubjectKeys
		for ($i = 0; $i < count($primarySubjectKeys); $i++) 
		{

			$secondarySubjectsForCurrentKey = [];

			// For each primarySubjectKey we loop thru the allSubjects array to get the secondarySubject values that match this key.
			foreach ($allSubjects as $key => $value) 
			{
				// Getting the PrimaryKey from both the allSubjects and primarySubjectKeys array.
				$currAllSubKey = $allSubjects[$key]["PrimarySubject"];
				$currPrimarySubKey = $primarySubjectKeys[$i];

				// Checking if their both have the same primarySubjecy key (needed since it can contiain duplicates)
				if ($currAllSubKey == $currPrimarySubKey) 
				{
					array_push($secondarySubjectsForCurrentKey, $value["SecondarySubject"]);
				}
			}

			// Adding the array of secondary subjects for the current primary subject to our secondarySubjects array
			$secondarySubjects[$primarySubjectKeys[$i]] = $secondarySubjectsForCurrentKey;
		}
		return $secondarySubjects;
	}
}


?>