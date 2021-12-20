<?php
require_once("../Models/sidebarModel.php");
require_once("../Controllers/controller.php");
require_once("../Views/sidebarView.php");

/** class for a specific controller */
class SidebarController extends Controller
{
	public function __construct()
	{
		$this->model = new SidebarModel();
		$this->view = new SidebarView();
	}
}

$controller = new SidebarController();
$response = $controller->register();
$objectsToRemove = [".subjectContainer", ".locationBar", ".postContainer", ".login"];
$response["objectsToRemove"] = $objectsToRemove;
echo json_encode($response);
?>