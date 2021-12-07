<?php  
require_once("model.php");

class ProposalModel extends Model 
{
	public function execute() : array 
	{
		$returnData = [];

		// Setting the locations for the locationsbar
		$returnData["locations"] = 
		[
			"Subject proposal" => "callController('.content', 'proposalController')",
		];

		return $returnData;
	}
}
?>