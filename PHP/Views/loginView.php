<?php  

require_once("../Views/view.php");

class LoginView extends View 
{
	private string $errorMessage;
	private string $view;

	function __construct() 
	{

		$this->errorMessage = "";

		$this->view = 	
		"
		<div class='loginContainer'>
		<div class='loginFormContainer' style='display:block;'>
		<button class='cancelButton' onClick='../Controllers/loginController.php'>
		<img src='../IMG/cancel.png' class='cancelImage'></img>
		</button>
		<form action='Controllers/registerController.php' method='POST'>
		<label for='text'>Username: </label>
		<input type='text' name='username' minlength='2' maxlength='30' required>
		<label for='password'>Password: </label>
		<input type='password' name='password' minlength='2' maxlength='30' required>
		<label class='confirmPassword' for='confirmPassword'>Confirm password</label>
		<input class='confirmPassword' type='password' name='confirmPassword' minlength='2' maxlength='30' required/>
		<br/>
		<input class='submitButton' type='submit' value='Log in'>
		<div class='loginErrorBox'>
		<p>" . $this->errorMessage . "</p>
		</div>
		</form>
		</div>
		</div>

		<html>
		<head>
		<title>Thoughtshare</title>
		</head>
		<body>
		<div class='overlay'/>	
		<div class='page'>
		<div class='content'>
		</div>
		<?php 	
		include_once('Include/header.inc.php');
		include_once('Include/sidebar.inc.php');
		?>
		</div>
		<link rel='stylesheet' type='text/css' href='../CSS/stylesheet.css'/>
		<link rel='stylesheet' type='text/css' href='../CSS/loginStyleSheet.css'/>
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
		<script type='text/javascript' src='../JS/loginButtonHandler.js'></script>
		<script type='text/javascript' src='../JS/SidebarFunctions.js'></script>
		</body>
		</html>
		";
	}
	

	public function getView() : string 
	{
		return $this->view;
	}

	public function setErrorMessage(string $errorMessage) 
	{
		$this->errorMessage = $errorMessage;
	}

}
?>