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

		// If the form is empty we dont want to continue
		if (empty($_POST))
		{
			return $returnData;
		}

		// Getting the values from the form
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

		$returnData["message"] = "Shit should be good";
		$returnData["messageType"] = "alertInfo";
		return $returnData;
	}
}
?>