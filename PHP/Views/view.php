<?php 
	require_once("../generalFunctions.php");
	/** View base class */

	class View 
	{
		/* Variable contains the html/content of the view */
		private string $viewContent = "";
		static private string $alertViewContent = "";

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
			$this->viewContent = $viewContent;
		}

		/**
		 * Function which will return the viewContent of a view
		 * 
		 * @return 
		 */
		public function getView() 
		{

			logError("varDump alertViewContent getView: " . $this::$alertViewContent);
			if ($this::$alertViewContent != "") 
			{
				logError("yes");
				return $this->viewContent . $this::$alertViewContent;

			}
			else 
			{
				logError("no");
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
				$this::$alertViewContent = $alertView;
				
			}
			logError("varDump alertViewContent handleOutput: " . var_export($this::$alertViewContent, true));	
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
			'<div class=" alert ' . $alertType . '">
			' . $alertMessage . '
			<button class="closeAlertBut imageButton" onClick="closeAlert();">
			<img class="closeAlertImage" src="../IMG/cancel.png">
			</button>
			</div>';
			return $alertView;
		}
	}
?>