<?php
require_once("../Models/postPageModel.php");
require_once("../Controllers/controller.php");
require_once("../Views/postPageView.php");

/** class for a specific controller */
class PostPageController extends Controller
{
	public function __construct()
	{
		$this->model = new PostPageModel();
		$this->view = new PostPageView();
	}
}

$controller = new PostPageController();

$response = $controller->register();

// Adding the object which need to be removed before adding the current view.
$objectsToRemove = [".locationBar", ".subjectContainer", ".postContainer"];
$response["objectsToRemove"] = $objectsToRemove;

echo json_encode($response);
?>