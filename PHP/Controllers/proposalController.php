<?php
require_once("../Models/proposalModel.php");
require_once("../Controllers/controller.php");
require_once("../Views/proposalView.php");

class ProposalController extends Controller
{
	public function __construct()
	{
		$this->model = new ProposalModel();
		$this->view = new ProposalView();
	}
}

$controller = new ProposalController();

$response = $controller->register();

// Adding the object which need to be removed before adding the current view.
$objectsToRemove = [".locationBar", ".subjectContainer", ".postContainer"];
$response["objectsToRemove"] = $objectsToRemove;

echo json_encode($response);
?>