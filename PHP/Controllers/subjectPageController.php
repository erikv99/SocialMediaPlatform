<?php  
require_once("../Controllers/controller.php");
require_once("../Views/subjectPageView.php");
require_once("../Models/subjectPageModel.php");

class SubjectPageController extends Controller 
{
	public function __construct() 
	{
		$this->view = new SubjectPageView();
		$this->model = new SubjectPageModel();
	}

}

$controller = new SubjectPageController();
$response = $controller->register();

// Adding the objects which need to be removed to the response
$objectsToRemove = [".subjectContainer", ".alert"];
$response["objectsToRemove"] = $objectsToRemove;
echo json_encode($response);
?>