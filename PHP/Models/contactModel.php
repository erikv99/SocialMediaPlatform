<?php  
require_once("model.php");

class ContactModel extends Model 
{
 	public function execute() : array 
 	{
 		$returnData = [];

		// Setting the locations for the locationsbar
		$returnData["locations"] = 
		[
			"Contact" => "callController('.content', 'contactController')"
		];
 		return $returnData;
 	}
} 
?>