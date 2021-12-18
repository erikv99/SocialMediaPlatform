<?php  

require_once("../Controllers/controller.php");
require_once("../Views/alertView.php");
require_once("../Models/alertModel.php");
/**
 * This class is a set up a bit different since we're not extending on View inside alertView.
 */
class AlertController  
{
	private $view; 
	private $model;

	public function __construct() 
	{
		$this->view = new AlertView();
		$this->model = new AlertModel(); 
	}

	public function register() 
	{	
		$modelOutput = $this->model->execute();

		// Checking if the modelOutput contains a alertMessage
		if (isset($modelOutput["alertMessage"])) 
		{
			// Recreating the view with the given message and message type
			$this->view = new AlertView($modelOutput["alertType"], $modelOutput["alertMessage"]);
		}

		// making the response array and returning it
		$response = ["view" => $this->view->getView()];
		
		return $response;
	}

}

$controller = new AlertController();
$response = $controller->register();
$objectsToRemove = [".login"];
$response["objectsToRemove"] = $objectsToRemove;
echo json_encode($response);
?>