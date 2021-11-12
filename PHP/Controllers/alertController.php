<?php  

require_once("../Controllers/controller.php");
require_once("../Views/alertView.php");

class AlertController extends Controller 
{
	public function __construct() 
	{
		$this->view = new AlertView();
	}

	public function register() 
	{	
		// making the response array and returning it
		$response = ["view" => $this->view->getView()];
		
		return $response;
	}

}

$controller = new AlertController();
$response = $controller->register();
$objectsToRemove = [".alert"];
$response["objectsToRemove"] = $objectsToRemove;
echo json_encode($response);
?>