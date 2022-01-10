<?php  
/* Will check if the user is logged in or not and if the user is admin or not */

session_start();


$response = ["loggedIn" => false, "isAdmin" => false];

// Checking if the loggedIn session variable is set
if (isset($_SESSION["loggedIn"]))
{
	// checking if it is set to true
    if ($_SESSION["loggedIn"] == true) 
    {
        $response["loggedIn"] = true;

        if ($_SESSION["isAdmin"] == true) 
        {
            $response["isAdmin"] = true;
        }
    }
}

echo json_encode($response);
?>