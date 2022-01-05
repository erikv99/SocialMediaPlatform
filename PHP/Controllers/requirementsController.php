<?php  
require_once("../Controllers/controller.php");
require_once("../Models/requirementsModel.php");
require_once("../Views/requirementsView.php");

/** class for a specific controller */
class RequirementsController extends Controller 
{
	public function __construct()
	{	
		// Making our model and view objects
		$this->model = new RequirementsModel();
		$this->view = new RequirementsView();
	}
} 

$controller = new RequirementsController();
$response = $controller->register();
$objectsToRemove = [".subjectContainer", ".locationBar", ".postContainer", ".login"];
$response["objectsToRemove"] = $objectsToRemove;
echo json_encode($response);
?>