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

			$currPrimaryKey = $currArray["PrimarySubject"];
			array_push($arrayKeys, $currPrimaryKey);
		}

		// Removing duplicates and reindexing them 
		$arrayKeys = array_values(array_unique($arrayKeys));

		logError(var_export($arrayKeys, true));

		// Put each subject and its sub-subjects in a individual container

		return $returnData;
	}
}

?>