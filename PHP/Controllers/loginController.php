<?php 

require_once("../Controllers/controller.php");
require_once("../Models/loginModel.php");

class LoginController extends controller 
{
	private Model $model;
	private View $view;

	function __construct()
	{
		// Calling the parent constructor 
		parent::construct();

		// Making our model and view objects
		$model = new LoginModel();
		$view = new LoginView();
	}

	public function getView() 
	{
		$view->getView();
	}

} 

$controller = new LoginController();
$controller->getView();
?>