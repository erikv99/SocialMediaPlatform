<?php  
require_once("../Controllers/controller.php");
require_once("../Models/accountPageModel.php");
require_once("../Views/accountPageView.php");

/** class for a specific controller */
class AccountPageController extends Controller 
{
	public function __construct()
	{	
		// Making our model and view objects
		$this->model = new AccountPageModel();
		$this->view = new AccountPageView();
	}
} 

$controller = new AccountPageController();
$response = $controller->register();
$objectsToRemove = [".subjectContainer", ".locationBar", ".postContainer", ".login"];
$response["objectsToRemove"] = $objectsToRemove;
echo json_encode($response);
?>