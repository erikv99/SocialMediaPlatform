<?php  
require_once("../Controllers/controller.php");
require_once("../Models/infoModel.php");
require_once("../Views/infoView.php");

/** class for a specific controller */
class InfoController extends Controller 
{
	public function __construct()
	{	
		// Making our model and view objects
		$this->model = new InfoModel();
		$this->view = new InfoView();
	}
} 

$controller = new InfoController();
$response = $controller->register();
$objectsToRemove = [".subjectContainer", ".locationBar", ".postContainer", ".login"];
$response["objectsToRemove"] = $objectsToRemove;
echo json_encode($response);
?>