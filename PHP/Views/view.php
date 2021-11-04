<?php 
	require_once("../generalFunctions.php");
	/** View base class */

	class View 
	{
		/* Variable contains the html/content of the view */
		private string $viewContent = "";

		// These variables are static so their state remains the same between calls
		static private string $alertViewContent = "";
		static private bool $returnAlertOnly = false;

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
		 * Function which will set the viewContent of a view
		 * 
		 */
		public function getView() 
		{
			// Returning either view, view + alertview or just the alertview
			if ($this::$alertViewContent != "" and $this::$returnAlertOnly == true) 
			{
				return $this->getAlertView();
			} 
			elseif ($this::$alertViewContent != "" and $this::$returnAlertOnly == false)
			{
				return $this->viewContent . $this->getAlertView();
			}
			else 
			{
				return $this->viewContent;
			}
		}

		/**
		 * Will handle the output given by model->execute
		 * 
		 * @param $output
		 */
		public function handleOutput($output) 
		{

			// Checking if the $output contains a  message key
			if (array_key_exists("message", $output))
			{
				// Setting the alert view
				$this->setAlertView($output["messageType"], $output["message"]);	
			}

			// Checking if the $output contains a getAlertOnly key indicating that only the alert should be returned (this is the case if a registry is succesfull)
			if (array_key_exists("getAlertOnly", $output)) 
			{
				// This is basically not needed since we only return the getAlertOnly key if its true but we check if its true in case we change the way this works later
				logError("getAlertOnly: " . $output["getAlertOnly"] . "if statement true or false: " . $output["getAlertOnly"] == true);
				if ($output["getAlertOnly"] == true) 
				{
					$this::$returnAlertOnly = true;
				}
			}
		}

		private function setAlertView($alertType, $alertMessage) 
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
			<img class="closeAlertImage" src="../IMG/cancel.png"/>
			</button>
			</div>';
			$this::$alertViewContent = $alertView;
		}

		public function getAlertView() : string 
		{
			return $this::$alertViewContent;
		}
	}
?>