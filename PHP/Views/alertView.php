<?php  
require_once("../Views/view.php");

class AlertView extends View
{
	public View $view;

	public function _construct($alertType = "", $alertMessage = "") 
	{
		$this->view = new View();
		$this->createView($alertType, $alertMessage);
	}

	private function createView($alertType = "", $alertMessage = "") 
	{
		if ($alertMessage == "") 
		{
			$alertMessage = "A error occured, please inform a administrator";
		}

		$this->view = new View();

		// If alertType is not valid we will return this as the error
		if ($alertType != "alertDanger" && $alertType != "alertInfo" && $alertType != "alertSuccess" && $alertType != "alertWarning") 
		{
			$alertType = "alertDanger";
		}
		
		$alertView = 
		'<div class=" alert ' . $alertType . '">
		' . $alertMessage . '
		<button class="closeAlertBut imageButton" onClick="closeAlert();">
		<img class="closeAlertImage" src="../IMG/cancel.png"/>
		</button>
		</div>';
		
		$this->view->setView($alertView);
	}
	public function getView() : string 
	{
		// if there is not yet a view object or the view inside it is empty we do createView()
		if (!isset($this->view) or $this->view->getView() == "") 
		{
			$this->createView();
		}

		logDebug("alertView getview: \n" . var_export($this->view->getView(), true));
		return $this->view->getView();
	}

}
?>