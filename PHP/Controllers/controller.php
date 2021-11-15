<?php
ini_set('memory_limit', '4000M'); 
require_once("../Models/model.php");
require_once("../Views/view.php");
require_once("../generalFunctions.php");
/** Controller base class */

class Controller
{
	public Model $model;
	public View $view;
	public string $viewToReturn;

	public function __construct() 
	{
		$this->viewToReturn = "ERROR: viewToReturn not set";
	}

	/**
	 * Will execute the model logic and return the view.
	 * 
	 * @return array containing a view and its content
	 */
	public function register() 
	{
		// Executing the logic in the model
		$output = $this->model->execute();

		// setting the output we got from the model execute function
		$this->view->setOutput($output);

		// getting the view from our view
		$this->viewToReturn = $this->view->getView();
		logDebug("viewtoreturn: " . var_export($this->view->getView(), true));
		// making the response array and returning it
		$response = ["view" => $this->viewToReturn];
		
		return $response;
	}
}
?>