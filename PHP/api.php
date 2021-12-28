<?php
require_once("generalFunctions.php");
header("Content-Type:application/json");

// Getting and splitting the URI 
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Trimming the uri to only get the parts relevant to us
$uri = getTrimmedURI($uri);

// Checking if the first arg isn't empty
if(empty($uri[0]))
{
	invalidInput();
}
	
$apiAction = $uri[0];

// Executing the right chain of events depending on the required api action
switch ($apiAction) 
{
	// Case we want all the users to be returned
	case 'users':
	
		$output = getUsers();
		break;

	// Case we want a specific user to be returned ../api/user/username
	case 'user':

		// Checking if the username arg isn't empty
		if (empty($uri[1])) 
		{ 
			invalidInput(); 
		}
		
		$username = $uri[1];
		$output = getUser($username);
		break;
	
	default:

		$output = "Unknown";
		break;
}

response(200, $output);

/**
 * Function for sending the response to the api request
 * 
 * @param $status, could be 200 for example if everything is ok.
 * @param $data, data to return
 */
function response($status, $data)
{
	header("HTTP/1.1 " . $status);
	
	$response['status'] = $status;
	$response['data'] = $data;
	
	$json_response = json_encode($response);
	echo $json_response;
}

/**
 * Function to get the trimmed URI. this means it only includes the stuff which comes after the /api/ part of the uri
 * 
 * @param string $uri
 * @return array $uri
 */
function getTrimmedURI($uri) 
{
	$uri = explode('/', $uri);

	// Getting the split index of "api"
	$apiIndex = array_search("api", $uri);

	// Unsetting all the uri parts before (and including) api.
	for ($i = 0; $i <= $apiIndex; $i++)
	{
		unset($uri[$i]);
	}

	// Reindexing the array.
	$uri = array_values($uri);
	return $uri;
}

/**
 * Function to call if the input for the api call is invalid. it will trigger the needed response
 */
function invalidInput() 
{
	response(400,"Invalid Request");		
	die();
}

/**
 * Function to get all the users from the database
 * 
 * @return array $dbOutput
 */
function getUsers()
{
	$dbConn = openDBConnection();

	try 
	{
		// Getting all secondary subjects for the current primary subject
		$stmt = $dbConn->prepare("SELECT username, creationDate, credits FROM users");
		$stmt->execute();
		$dbOutput = $stmt->fetchAll();		
	}
	catch (PDOException $e) 
	{
		echo $e->getMessage();
	}

	closeDBConnection($dbConn);

	return $dbOutput;
}

/**
 * Function to get a specific user from the database.
 * 
 * @param string $username
 * @return array $dbOutput
 */
function getUser(string $username) 
{
	$dbConn = openDBConnection();

	try 
	{
		// Getting all secondary subjects for the current primary subject
		$stmt = $dbConn->prepare("SELECT username, creationDate, credits FROM users WHERE UPPER(username) = UPPER(?)");
		$stmt->execute([$username]);
		$dbOutput = $stmt->fetchAll();		
	}
	catch (PDOException $e) 
	{
		echo $e->getMessage();
	}

	closeDBConnection($dbConn);

	if (empty($dbOutput)) 
	{
		$dbOutput = "User not found";
	}
	
	return $dbOutput;
} 
