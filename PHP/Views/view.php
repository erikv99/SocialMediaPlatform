<?php 

	/** View base class */

	class View 
	{
		/* Variable contains the html/content of the view */
		private string $viewContent = "";
		private string $alertViewContent = "";
		private bool $includeAlertView = false;

		function __construct() 
		{
		}

		/**
		 * Function to set the viewContent of a view
		 * 
		 * @param string $viewContent
		 */
		public function setView($viewContent)
		{
			$this->viewContent = $viewContent;
		}

		/**
		 * Function which will return the viewContent of a view
		 * 
		 * @return string $viewContent
		 */
		public function getView() : string 
		{
			if ($this->includeAlertView) 
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
				$this->includeAlertView = true;
			}			
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

			return $alertView;
		}
	}
?>