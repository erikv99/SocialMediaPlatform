<?php
require_once("../Models/model.php");
require_once("../Views/view.php");
require_once("../generalFunctions.php");
/** Controller base class */

class Controller
{
	public Model $model;
	public View $view;

	/**
	 * Will execute the model logic and return the view.
	 * 
	 * @return array containing a view and its content
	 */
	public function register() 
	{
		session_start();
		
		// Executing the logic in the model
		$output = $this->model->execute();

		// setting the output we got from the model execute function
		$this->view->setOutput($output);

		// getting the view from our view
		$viewToReturn = $this->view->getView();
				
		// making the response array and returning it
		$response = ["view" => $viewToReturn];
		
		return $response;
	}
}
?>