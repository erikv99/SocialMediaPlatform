<?php
require_once("../Models/registerModel.php");
require_once("../Controllers/controller.php");
require_once("../Views/registerView.php");
require_once("../generalFunctions.php");

class RegisterController extends Controller 
{
	public function __construct()
	{	
		// Making our model and view
		$this->model = new RegisterModel();
		$this->view = new RegisterView();
	}

}

$controller = new RegisterController();
$response = $controller->register();
echo json_encode($response);
?>