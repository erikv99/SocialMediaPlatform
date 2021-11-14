<?php 
require_once("../Views/view.php");

class RegisterView extends View 
{	

	function __construct() 
	{
		$this->createView();
	}
	
	protected function createView() 
	{
		$cancelImgPath = "../IMG/cancel.png";
		$this::$viewContent =
		"
		<div class='login'>
		<div class='overlay'/>	
		<div class='loginContainer'>
		<div class='loginFormContainer' style='display:block;'>
		<button class='cancelButton' onClick='closeLoginContainer();'>
		<img src='" . $cancelImgPath . "' class='cancelImage'></img>
		</button>
		<form class='loginForm' onsubmit='callControllerFromForm(\"body\", \"registerController\", \"loginForm\"); return false;' method='POST'>
		<label for='text'>Username: </label>
		<input type='text' name='username' minlength='2' maxlength='30' required>
		<label for='password'>Password: </label>
		<input type='password' name='password' minlength='2' maxlength='30' required>
		<label class='confirmPassword' for='confirmPassword'>Confirm password</label>
		<input class='confirmPassword' type='password' name='confirmPassword' minlength='2' maxlength='30' required/>
		<br/>
		<input class='submitButton button' type='submit' value='Sign up'>
		</form>
		</div>
		</div>
		</div>
		";
	}

	public function getView() : string
	{
		// Updating the view (incase message has been changed)
		$this->createView();

		// Getting the view and returning it
		return Parent::getViewContent();
	}
}
?>