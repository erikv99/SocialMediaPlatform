<?php 

require_once("../Controllers/controller.php");
require_once("../Models/loginModel.php");
require_once("../Views/loginView.php");

class LoginController extends controller 
{
	private Model $model;
	private View $view;

	public function __construct()
	{	

		// Making our model and view objects
		$this->model = new LoginModel();
		$this->view = new LoginView();
	}

	public function getView() 
	{
		return $this->view->getView();
	}

} 

$controller = new LoginController();
$viewToReturn = $controller->getView();
$jsonResponse = ["view", $viewToReturn];

echo json_encode($jsonResponse);
?>