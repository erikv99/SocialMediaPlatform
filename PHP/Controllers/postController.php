<?php
require_once("../Models/postModel.php");
require_once("../Controllers/controller.php");
require_once("../Views/postView.php");

class PostController extends Controller
{
	public function __construct()
	{
		$this->model = new PostModel();
		$this->view = new PostView();
	}
}

$controller = new PostController();

$response = $controller->register();

// Adding the object which need to be removed before adding the current view.
$objectsToRemove = [".locationBar"];
$response["objectsToRemove"] = $objectsToRemove;

echo json_encode($response);
?>