<?php  
require_once("../Models/contentModel.php");
require_once("../Controllers/controller.php");
require_once("../Views/contentView.php");

class ContentController extends Controller 
{
	public function __construct()
	{
		$this->model = new ContentModel();
		$this->view = new ContentView();
	}
}

$controller = new ContentController();

// TODO : add objectsToRemove if needed

$response = $controller->register();
echo json_encode($response);
?>