<?php 

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
	 * @return "message" and "messageType" if a message is needed
	 */
	public function execute() 
	{
		// In case this function is not used in the specific model it is still called by the controller as per design. thats why we want to return these values so the program doesnt have a panic attack
		$returnData = ["message" => ""];
		return $returnData;
	}

	/**
	 * Function will open a db connection and return it
	 * 
	 * @return 
	 */
	protected function openDBConnection()
	{ 
		$dbHost = "localhost";
		$dbUser = "root";
		$dbPass = "";
		$dbName = "thoughtshare";

		try 
		{
			$conn = new PDO("mysql:host=" . $dbHost . ";dbname=" . $dbName . ";", $dbUser, $dbPass);
		}
		catch (PDOException $e) 
		{
			die("<br>Database connection failed: " . $e->getMessage());
		}

		return $conn;
	}

	/**
	 * Function for closing a existing database connection
	 * 
	 * @param open database connection
	 */ 
	protected function closeDBConnection($conn)
	{	
	$conn = null;
	}

}
?>