<?php  

require_once("../Views/view.php");

class LoginView extends View 
{

	private View $view;

	function __construct() 
	{
		$this->view = new View();
		$this->createView();
	}

	private function createView() 
	{
		$cancelImgPath = "../IMG/cancel.png";
		$this->view->setView( 	
		"
		<div class='login'>
		<div class='overlay'/>	
		<div class='loginContainer'>
		<div class='loginFormContainer' style='display:block;'>
		<button class='cancelButton' onClick='closeLoginContainer();'>
		<img src='" . $cancelImgPath . "' class='cancelImage'></img>
		</button>
		<form class='loginForm' onsubmit='callControllerFromForm(\"body\", \"loginController\", \"loginForm\"); return false;' method='POST'>
		<label for='text'>Username: </label>
		<input type='text' name='username' minlength='2' maxlength='30' required>
		<label for='password'>Password: </label>
		<input type='password' name='password' minlength='2' maxlength='30' required>
		<br/>
		<input class='submitButton' type='submit' value='Log in'>
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
}
?>