<?php  
require_once("model.php");

/** specific model class for the contact */
class ContactModel extends Model 
{
	/** 
	 * Executes the logic required for the specific model, sets any needed output and returns it.
	 * 
	 * @return array $output
	 */
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