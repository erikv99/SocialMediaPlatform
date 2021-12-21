<?php  
/* Will return all secondary subjects of the given primary subject. */
include_once("../generalFunctions.php");
session_start();

$response = [];

$primarySubject = htmlspecialchars($_POST["primarySubject"], ENT_QUOTES | ENT_HTML5, 'UTF-8');

$dbConn = openDBConnection();
$dbOutput = []; 

try
{
// Getting all secondary subjects for the current primary subject
$stmt = $dbConn->prepare("SELECT SecondarySubject FROM subjects WHERE PrimarySubject = ? AND SecondarySubject IS NOT NULL");
$stmt->execute([$primarySubject]);
$dbOutput = $stmt->fetchAll();
}
catch (PDOException $e)
{
throw new DBException($e->getMessage());
}   

closeDBConnection($conn);

$secondarySubjects = [];

// Since the db output contains of array containing the secondarysubject(s) we unpack them here.
for ($i = 0; $i < count($dbOutput); $i++) 
{
array_push($secondarySubjects, $dbOutput[$i][0]);
}

$response["secondarySubjects"] = $secondarySubjects;
echo json_encode($response);
?>