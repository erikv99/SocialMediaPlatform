<?php
require_once("../Models/contactModel.php");
require_once("../Controllers/controller.php");
require_once("../Views/contactView.php");

/** class for a specific controller */
class ContactController extends Controller
{
	public function __construct()
	{
		$this->model = new ContactModel();
		$this->view = new ContactView();
	}
}

$controller = new ContactController();
$response = $controller->register();
$objectsToRemove = [".subjectContainer", ".locationBar", ".postContainer", ".login"];
$response["objectsToRemove"] = $objectsToRemove;
echo json_encode($response);
?>