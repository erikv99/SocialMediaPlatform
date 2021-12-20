<?php  
require_once("model.php");

/** specific model class for the header */
class HeaderModel extends Model 
{
	/** 
	 * Executes the logic required for the specific model, sets any needed output and returns it.
	 * 
	 * @return array $output
	 */
 	public function execute() : array 
 	{
 		$returnData = [];
 		$returnData["username"] = "";

 		if ($this->isUserLoggedIn()) 
 		{
 			$returnData["username"] = $_SESSION["username"];
 		} 

 		// Making sure we're not getting a extra location bar
		$returnData["locations"] = ["noLocationBar" => true,];

 		return $returnData;
 	}
} 
?>