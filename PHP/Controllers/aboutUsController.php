<?php
require_once("../Models/aboutUsModel.php");
require_once("../Controllers/controller.php");
require_once("../Views/aboutUsView.php");

/** class for a specific controller */
class AboutUsController extends Controller
{
	public function __construct()
	{
		$this->model = new AboutUsModel();
		$this->view = new AboutUsView();
	}
}

$controller = new AboutUsController();
$response = $controller->register();
$objectsToRemove = [".subjectContainer", ".locationBar", ".postContainer", ".login"];
$response["objectsToRemove"] = $objectsToRemove;
echo json_encode($response);
?>