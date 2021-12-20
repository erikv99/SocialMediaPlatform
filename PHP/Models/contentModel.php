<?php  
require_once("model.php");

/** specific model class for the content */
class ContentModel extends Model 
{
	/** 
	 * Executes the logic required for the specific model, sets any needed output and returns it.
	 * 
	 * @return array $output
	 */
	public function execute() : array 
	{
		$returnData = [];
		
		// Getting the subjects array (key = primarySubject value = arrray of secondary subjects)
		$returnData["subjects"] = $this->getSubjects();

		// Setting the locations for the locationsbar
		$returnData["locations"] = 
		[
			"Subjects" => "callController('.content', 'contentController')"
		];

		return $returnData;
	}
}


?>