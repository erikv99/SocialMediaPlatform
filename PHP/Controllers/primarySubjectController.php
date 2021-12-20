<?php  
require_once("../Controllers/controller.php");
require_once("../Views/primarySubjectView.php");
require_once("../Models/primarySubjectModel.php");

/** class for a specific controller */
class PrimarySubjectController extends Controller 
{
	public function __construct() 
	{
		$this->view = new PrimarySubjectView();
		$this->model = new PrimarySubjectModel();
	}

}

$controller = new PrimarySubjectController();
$response = $controller->register();

// Adding the objects which need to be removed to the response
$objectsToRemove = [".subjectContainer",".locationBar", ".postContainer", ".login"];
$response["objectsToRemove"] = $objectsToRemove;
echo json_encode($response);
?>