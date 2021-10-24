<?php 
require_once("../Views/registerView.php");
require_once("../Models/model.php");

class RegisterModel extends Model  
{
	public function __construct() 
	{

	}

	public function execute() 
	{
		// Checking if the form is not empty. if it is empty we can return and do not need to execute any data
		if ($_SERVER['REQUEST_METHOD'] != 'POST') 
		{
			return "no data retrieval needed";
		}

		$data = $this->getData();

		// Checking if given password and confirmpassword match
		if ($data["password"] != $data["confirmPassword"]) 
		{
			return "Passwords do not match";
		}


	return "";
	}

	private function getData() 
	{
		$data = [
			"username" => $_POST["username"],
			"password" => $_POST["password"],
			"confirmPassword" => $_POST["confirmPassword"]
		];

		return $data;
	}
}
?>