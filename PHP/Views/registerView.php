<?php 
require_once("view.php");

class RegisterView extends View 
{		
	/**
	 * Creates the view and returns it
	 * 
	 * @param array $modelView
	 * @return string $view
	 */
	protected function createView(array $modelOutput) : string
	{
		$cancelImgPath = "../IMG/cancel.png";
		$view =
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

		return $view;
	}

	public function getView() : string
	{
		// Updating the view (incase message has been changed)
		$this::$viewContent = $this->createView($this::$output);

		// Getting the view and returning it
		return Parent::getViewContent();
	}
}
?>