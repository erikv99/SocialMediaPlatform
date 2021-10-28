<?php 
require_once("../Include/dbConnect.php");

/** Model base class */
class Model
{


	public function __construct()
	{

	}

	/**
	 * Function which will execute the logic inside the model class. since this function is always being called it must have a return value.
	 * 
	 * @return "" is no error
	 * @return "errorMessage" if a error is found
	 */
	public function execute() 
	{
		// In case this function is not used in the specific model it is still called by the controller as per design. thats why we want to return these values so the program doesnt have a panic attack
		$returnData = ["indexViewRequired" => false, "message" => ""];
		return $returnData;
	}

}
?>