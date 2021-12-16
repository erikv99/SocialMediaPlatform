<?php
require_once("../Models/headerModel.php");
require_once("../Controllers/controller.php");
require_once("../Views/headerView.php");

class HeaderController extends Controller
{
	public function __construct()
	{
		$this->model = new HeaderModel();
		$this->view = new HeaderView();
	}
}

$controller = new HeaderController();
$response = $controller->register();
echo json_encode($response);
?>