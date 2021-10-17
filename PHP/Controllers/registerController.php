<?php
require_once("../Models/registerModel.php");
require_once("../Controllers/controller.php");
//require_once("../Views/registerView.php");

class RegisterController extends Controller 
{
	private View $view;
	private Model $model;

	function __construct()
	{	
		// Calling the parent constructor
		parent::construct();

		// Making our model and view
		$this->model = new RegisterModel();
		$this->view = new RegisterView();

	}

	function register () 
	{
		// Assigning the value from post to our variables
		$userName = $_POST["username"];
		$password = $_POST["password"];
		$confirmPassword = $_POST["confirmPassword"];
		
		$this->model->test();
		echo $this->view->getView();
	}	
}

//$rController = new RegisterController();
//$rController->register();
?>