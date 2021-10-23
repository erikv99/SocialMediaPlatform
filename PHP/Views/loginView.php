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
		<p> " . $this->errorMessage . "</p>
		</div>
		</form>
		</div>
		</div>
		";
	}
	

	public function getView() : string 
	{
		parent::__construct();
		// Setting the content in the view we will get from the parent
		parent::setContent($this->view);

		// Getting the view from the parent which now has the view of this class as content
		$viewToReturn = parent::getView();

		// Returning the view
		return $viewToReturn;
	}

	public function setErrorMessage(string $errorMessage) 
	{
		$this->errorMessage = $errorMessage;
	}

}
?>