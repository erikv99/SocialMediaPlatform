<?php  
require_once("../Controllers/controller.php");
require_once("../Views/secondarySubjectView.php");
require_once("../Models/secondarySubjectModel.php");

class SecondarySubjectController extends Controller 
{
	public function __construct() 
	{
		$this->view = new SecondarySubjectView();
		$this->model = new SecondarySubjectModel();
	}

}

$controller = new SecondarySubjectController();
$response = $controller->register();

// Adding the objects which need to be removed to the response
$objectsToRemove = [".subjectContainer", ".alert", ".locationBar", ".postContainer", ".login"];
$response["objectsToRemove"] = $objectsToRemove;
echo json_encode($response);
?>