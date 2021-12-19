<?php  
	// File which only gets called by a ajax request, handles logging out the user.
	session_start();
	$_SESSION['loggedIn'] = false;
	$_SESSION['isAdmin'] = false;
	$_SESSION['username'] = "";
?>