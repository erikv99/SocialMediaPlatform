<?php  

require_once("../Views/view.php");

class LoginView extends View 
{
	private string $errorMessage;
	private View $view;

	function __construct() 
	{
		$this->view = new View();
		$this->errorMessage = "";
		$this->createView();
	}

	// This function is needed since if "errormessage" is changed it the view needs to be updated
	private function createView() 
	{
		$this->view->setView( 	
		"
		<div class='login'>
		<div class='overlay'/>	
		<div class='loginContainer'>
		<div class='loginFormContainer' style='display:block;'>
		<button class='cancelButton' onClick='closeLoginContainer();'>
		<img src='../IMG/cancel.png' class='cancelImage'></img>
		</button>
		<form action='Controllers/registerController.php' method='POST'>
		<label for='text'>Username: </label>
		<input type='text' name='username' minlength='2' maxlength='30' required>
		<label for='password'>Password: </label>
		<input type='password' name='password' minlength='2' maxlength='30' required>
		<br/>
		<input class='submitButton' type='submit' value='Log in'>
		<div class='loginErrorBox'>
		</div>
		</form>
		</div>
		</div>
		</div>
		");
	}

	public function getView() : string
	{
		// Updating the view (incase error message has been changed)
		$this->createView();

		// Returning the view
		return $this->view->getView();
	}

	// Function for updating the error message for this view.
	public function setErrorMessage(string $errorMessage) 
	{
		$this->errorMessage = $errorMessage;
	}
}
?>