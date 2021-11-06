<?php  
/* Will check if the user is logged in or not */

session_start();

// Resonse loginButtonsAction is show on default. will be put on hide if user is logged in already
$response = ["loginButtonsAction" => "show"];

// Checking if the loggedIn session variable is set
if (isset($_SESSION["loggedIn"]))
{
	// checking if it is set to true
    if ($_SESSION["loggedIn"] == true) 
    {
        $response["loginButtonsAction"] = "hide";
    }
}

echo json_encode($response);
?>