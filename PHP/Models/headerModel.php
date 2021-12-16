<?php  
require_once("model.php");

class HeaderModel extends Model 
{
 	public function execute() : array 
 	{
 		$returnData = [];
 		
 		// Making sure we're not getting a extra location bar
		$returnData["locations"] = ["noLocationBar" => true,];

 		return $returnData;
 	}
} 
?>