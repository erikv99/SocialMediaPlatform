<?php 
	require_once("../generalFunctions.php");
	/** View base class */

	class View 
	{
		/* Variable contains the html/content of the view */
		private string $viewContent = "t";
		private string $alertViewContent = "t";

		function __construct() 
		{
			logError("constructor called, caller: " . getCallingFunctionName());

		}

		function __destruct()
		{
			logError("destructor called");
		}

		/**
		 * Function to set the viewContent of a view
		 * 
		 * @param string $viewContent
		 */
		public function setView($viewContent)
		{
			logError("varDump alertViewContent setView: " . var_export($this->alertViewContent, true));
			$this->viewContent = $viewContent;
		}

		/**
		 * Function which will return the viewContent of a view
		 * 
		 * @return string $viewContent
		 */
		public function getView() : string 
		{
			logError("varDump alertViewContent getView: " . var_export($this->alertViewContent, true));
			if ($this->alertViewContent != "") 
			{
				return $this->viewContent . $this->alertViewContent;

			}
			else 
			{
				return $this->viewContent;
			}


		}

		public function handleOutput($output) 
		{


			// Checking if the $output contains a  message that isnt empty
			if ($output["message"] != "") 
			{
				// Getting the alert view
				$alertView = $this->getAlertView($output["messageType"], $output["message"]);

				// Adding the alert view to our current view 
				$this->alertViewContent = $alertView;
			}
			logError("varDump alertViewContent handleOutput: " . var_export($this->alertViewContent, true));	
		}

		private function getAlertView($alertType, $alertMessage) 
		{	
			
			// Available alert types are, alertDanger, alertInfo, alertSuccess and alertWarning

			// If alertType is not valid we will return this as the error
			if ($alertType != "alertDanger" && $alertType != "alertInfo" && $alertType != "alertSuccess" && $alertType != "alertWarning") 
			{
				$alertType = "alertDanger";
			}

			$alertView = 
			'<div class="' . $alertType . '">
			' . $alertMessage . '
			<button class="closeAlertBut imageButton" onClick="closeAlert();">
			<img class="closeAlertImage" src="../IMG/cancel.png">
			</button>
			</div>';
			logError("varDump alertViewContent getAlertView: " . var_export($this->alertViewContent, true));
			return $alertView;
		}
	}
?>