<?php  
require_once("../Controllers/controller.php");
require_once("../Models/adminModel.php");
require_once("../Views/adminView.php");

/** class for a specific controller */
class AdminController extends Controller 
{
	public function __construct()
	{	
		// Making our model and view objects
		$this->model = new AdminModel();
		$this->view = new AdminView();
	}
} 

$controller = new AdminController();
$response = $controller->register();
$objectsToRemove = [".subjectContainer", ".locationBar", ".postContainer", ".login"];
$response["objectsToRemove"] = $objectsToRemove;
echo json_encode($response);
?>