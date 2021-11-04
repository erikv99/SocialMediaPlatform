<?php 

/** Model base class */
class Model
{


	public function __construct()
	{

	}

	/**
	 * Function which will execute the logic inside the model class.
	 * 
	 */
	public function execute() 
	{
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