<?php 

require_once("../Controllers/controller.php");
require_once("../Models/loginModel.php");
require_once("../Views/loginView.php");

/** class for a specific controller */
class LoginController extends Controller 
{
	public function __construct()
	{	
		// Making our model and view objects
		$this->model = new LoginModel();
		$this->view = new LoginView();
	}
} 

$controller = new LoginController();
$response = $controller->register();
$objectsToRemove = [".login"];
$response["objectsToRemove"] = $objectsToRemove;
echo json_encode($response);
?>