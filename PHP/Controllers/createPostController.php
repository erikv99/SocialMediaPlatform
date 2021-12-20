<?php
require_once("../Models/createPostModel.php");
require_once("../Controllers/controller.php");
require_once("../Views/createPostView.php");

/** class for a specific controller */
class CreatePostController extends Controller
{
	public function __construct()
	{
		$this->model = new CreatePostModel();
		$this->view = new CreatePostView();
	}
}

$controller = new CreatePostController();

$response = $controller->register();

// Adding the object which need to be removed before adding the current view.
$objectsToRemove = [".locationBar", ".subjectContainer", ".postContainer"];
$response["objectsToRemove"] = $objectsToRemove;

echo json_encode($response);
?>