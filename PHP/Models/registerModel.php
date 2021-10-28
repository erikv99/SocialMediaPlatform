<?php 
require_once("../Views/registerView.php");
require_once("../Models/model.php");

class RegisterModel extends Model  
{
	public function __construct() 
	{
		$dbConnection = openConnection();
	}

	public function execute() : array
	{
		$returnData = ["indexViewRequired" => false, "message" => ""];

		// Checking if the form is not empty. if it is empty we can return and do not need to execute any data
		if (!isset($_POST["username"])) 
		{
			$returnData["message"] = "No data retrieval needed";
			$returnData["messageType"] = "alertInfo";
			return $returnData;
		}

		$returnData["indexViewRequired"] = true;

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
		
		return $returnData;
	}
}
?>