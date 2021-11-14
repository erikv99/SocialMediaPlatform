<?php  
require_once("../Models/model.php");

class ContentModel extends Model 
{
	public function __construct() {}

	public function execute() : array 
	{
		$returnData = [];

		// Getting the results table from our database
		$dbOutput = $this->getSubjectsFromDatabase();

		// Getting the primarySubjects from the database output
		$primarySubjects = $this->getPrimarySubjects($dbOutput);

		// Gettubg tge secondary and primary subjects in a array
		$subjects = $this->getSecondarySubjects($primarySubjects, $dbOutput);
		
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

	/**
	 * Function for getting all the data entries for "subjects" from the database
	 * 
	 * @return array containing the database return values.
	 */
	private function getSubjectsFromDatabase() : array
	{

		// Get all subjects with their sub-subject.
		$dbConn = $this->openDBConnection();
		$dbOutput = [];
		
		try
		{
			// Getting all primary and secondary subjects
			$stmt = $dbConn->prepare("SELECT * FROM `subjects`");
			$stmt->execute();
			$dbOutput = $stmt->fetchAll();
		}
		catch (PDOException $e)
		{
			throw new DBException($e->getMessage());
		}	
		
		return $dbOutput;
	}

	/**
	 * Function for getting all the primary subjects in a seperate array from out dbOutput.
	 * 
	 * We need this function since array_keys() wont be usuable in our case
	 * 
	 * @param array containing the dbOutput from the results table
	 * @return array containing all primary subject inside the dbOutput
	 */
	private function getPrimarySubjects($dbOutput) 
	{
		// Getting all primary subjects from our dbResults and putting them in a seperate array
		$primarySubjects = [];

		for ($i = 0; $i < count($dbOutput); $i++) 
		{
			// Since each index is a array in itself we put it in a var first
			$currArray = $dbOutput[$i];
	
			// Getting the primary key and adding it to our primaryKeys array.
			$currPrimaryKey = $currArray["PrimarySubject"];
			array_push($primarySubjects, $currPrimaryKey);
		}

		return $primarySubjects;
	}
}


?>