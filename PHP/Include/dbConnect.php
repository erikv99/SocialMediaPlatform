<?php  
function openConnection()
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
 
function closeConnection($conn)
{	
	$conn = null;
}
?>