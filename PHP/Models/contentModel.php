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
}


?>