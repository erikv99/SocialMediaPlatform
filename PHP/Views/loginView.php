<?php  

require_once("../Views/view.php");

class LoginView extends View 
{

	function __construct() 
	{
		// Calling the parent constructor
		parent::construct();
	}
	
	private string $errorMessage = ""
	private string $view = 
	"
	<div class='loginContainer'>
	<div class='loginFormContainer'>
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
				<p>" . $errorMessage . "</p>
			</div>
		</form>
	</div>
	</div>
	"

	public function getView() : string 
	{
		return $view
	}

	public function setErrorMessage(string $errorMessage) 
	{
		$this->errorMessage = $errorMessage;
	}

}
?>