<?php
require_once("../Models/registerModel.php");
require_once("../Controllers/controller.php");
require_once("../Views/registerView.php");

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

// Adding the object which need to be removed before adding the current view.
$objectsToRemove = [".login", ".alert"];

// Getting the view from the controller
$response = $controller->register();

// Adding the objects which need to be removed to the response 
$response["objectsToRemove"] = $objectsToRemove;

echo json_encode($response);
?>