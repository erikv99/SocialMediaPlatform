<?php 
require_once("../Views/registerView.php");
require_once("../Models/model.php");
require_once("../generalFunctions.php");
class RegisterModel extends Model  
{
	public function __construct() 
	{
		//$dbConnection = openConnection();
	}

	public function execute() : array
	{
		$returnData = ["message" => ""];

		// Checking if the form is not empty. if it is empty we can return and do not need to execute any data
		logError("Post content: " . var_export($_POST, true) );

		if (empty($_POST))
		{
			logError("POST EMPTY");
			$returnData["message"] = "No data retrieval needed";
			$returnData["messageType"] = "alertInfo";
			return $returnData;
		}

		logError("post username val: " . $_POST["username"]);
		$username = $_POST["username"];
		$password = $_POST["password"];
		$confirmPassword = $_POST["confirmPassword"];

		// Checking if given password and confirmpassword match
		if ($password != $confirmPassword) 
		{
			$returnData["message"] = "Passwords do not match";
			$returnData["messageType"] = "alertDanger";
			return $returnData;
		}

			$returnData["message"] = "fucking work";
			$returnData["messageType"] = "alertDanger";
		return $returnData;
	}
}
?>