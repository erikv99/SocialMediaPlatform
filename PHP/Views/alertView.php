<?php  

/**
 * View class for alerts, does not extend view since it doesn't use its functions.
 */
class AlertView
{
	static private string $alertView = "";

	public function __construct($alertType = "", $alertMessage = "") 
	{
		$this::$alertView = $this->createView($alertType, $alertMessage);
	}

	public function createView($alertType = "", $alertMessage = "") 
	{
		if ($alertMessage == "") 
		{
			$alertMessage = "A error occured, please inform a administrator";
		}

		// If alertType is not valid we will return this as the error
		if ($alertType != "alertError" && $alertType != "alertInfo" && $alertType != "alertSuccess" && $alertType != "alertWarning") 
		{
			$alertType = "alertError";
		}
		
		$view = 
		'<div class=" alert ' . $alertType . '">
		' . $alertMessage . '
		<button class="closeAlertBut imageButton" onClick="closeAlert();">
		<img class="closeAlertImage" src="../IMG/cancel.png"/>
		</button>
		</div>';

		return $view;
	}
	public function getView() : string 
	{
		// if there is not yet a view object or the view inside it is empty we do createView()
		if ($this::$alertView == "") 
		{
			$this::$alertView = $this->createView();
		}

		return $this::$alertView;
	}

}
?>