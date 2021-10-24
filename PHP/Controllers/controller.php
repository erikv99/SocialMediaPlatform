<?php
require_once("../Models/model.php");
require_once("../Views/view.php");

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

		// If a error occured we're giving that error to the view (return vals for execute = "" = no error "error message" = error)
		$this->view->setErrormessage($output);

		// getting the view from our view
		$this->viewToReturn = $this->view->getView();

		// making the response array and returning it
		$response = ["view" => $this->viewToReturn,];
		return $response;
	}

}
?>