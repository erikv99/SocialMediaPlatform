<?php  
require_once("../Models/contentModel.php");
require_once("../Controllers/controller.php");
require_once("../Views/contentView.php");

/** class for a specific controller */
class ContentController extends Controller 
{
	public function __construct()
	{
		$this->model = new ContentModel();
		$this->view = new ContentView();
	}
}

$controller = new ContentController();

$response = $controller->register();

// Adding the object which need to be removed before adding the current view.
$objectsToRemove = [".subjectContainer", ".locationBar", ".postContainer", ".login"];
$response["objectsToRemove"] = $objectsToRemove;

echo json_encode($response);
?>