<?php  
require_once("../Controllers/controller.php");
require_once("../Models/homeModel.php");
require_once("../Views/homeView.php");

/** class for a specific controller */
class HomeController extends Controller 
{
	public function __construct()
	{	
		// Making our model and view objects
		$this->model = new HomeModel();
		$this->view = new HomeView();
	}
} 

$controller = new HomeController();
$response = $controller->register();
$objectsToRemove = [".subjectContainer", ".locationBar", ".postContainer", ".login"];
$response["objectsToRemove"] = $objectsToRemove;
echo json_encode($response);
?>