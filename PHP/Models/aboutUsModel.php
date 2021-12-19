<?php  
require_once("model.php");

class AboutUsModel extends Model 
{
 	public function execute() : array 
 	{
 		$returnData = [];

		// Setting the locations for the locationsbar
		$returnData["locations"] = 
		[
			"About us" => "callController('.content', 'aboutUsController')"
		];
 		return $returnData;
 	}
} 
?>