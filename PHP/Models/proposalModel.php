<?php  
require_once("model.php");

class ProposalModel extends Model 
{
	public function execute() : array 
	{
		$returnData = [];

		logDebug("POST: " . var_export($_POST,true));
		
		// Getting the primary subjects, needed in the view.
		$primarySubjects = $this->getPrimarySubjects();
		$returnData["primarySubjects"] = $primarySubjects;

		// Setting the locations for the locationsbar
		$returnData["locations"] = 
		[
			"Subject proposal" => "callController('.content', 'proposalController')",
		];

		return $returnData;
	}
}
?>