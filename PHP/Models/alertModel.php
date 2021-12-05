<?php  
Class AlertModel 
{
	public function execute () 
	{
		$returnData = [];

		// if posts contains a data property
		if (isset($_POST["data"])) 
		{
			// If the data contains a array
			if (is_array($_POST["data"])) 
			{
				$dataArray = $_POST["data"];

				// If the fields we need are set
				if (isset($dataArray["alertMessage"]) and isset($dataArray["alertType"])) 
				{
					$returnData["alertMessage"] = $dataArray["alertMessage"];
					$returnData["alertType"] = $dataArray["alertType"];
				}
			}
		}
		return $returnData;
	}
}
?>