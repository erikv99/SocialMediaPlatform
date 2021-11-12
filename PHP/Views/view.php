<?php 
	require_once("../generalFunctions.php");
	require_once("alertView.php");

	/** View base class */

	class View 
	{
		/* Variable contains the html/content of the view */
		private string $viewContent = "";

		// These variables are static so their state remains the same between calls
		static private bool $returnAlertOnly = false;
		static private array $output = [];

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
		 * Function which will return the view
		 * 
		 * There are 2 options.
		 * Getting just the normal view + alertview (filled if set empty if not set)
		 * Getting only the alertview
		 * 
		 * @return correct view depending on the situation.
		 */
		public function getView() 
		{
			$output = $this::$output;
			$alertView = "";

			// Checking if the view requires a alert or not
			if (isset($output["messageType"]) and isset($output["message"]))
			{	
				// Getting the view of the alert
				$alertViewObj = new ALertView($output["messageType"], $output["message"]);
				$alertView = $alertViewObj->getView();
			}

			// Returning either only the alertview or view + alertview (can be empty or not)
			if ($this::$returnAlertOnly) 
			{
				return $alertView;
			}
			else 
			{
				return $this->viewContent . $alertView;
			}
		}

		/**
		 * Will handle the output given by model->execute
		 * 
		 * @param $output
		 */
		public function handleOutput($output) 
		{

			// Checking if the $output contains a getAlertOnly key indicating that only the alert should be returned (this is the case if a registry is succesfull)
			if (array_key_exists("getAlertOnly", $output)) 
			{
				// This is basically not needed since we only return the getAlertOnly key if its true but we check if its true in case we change the way this works later
				if ($output["getAlertOnly"] == true) 
				{
					$this::$returnAlertOnly = true;
				}
			}

			// After checking if we only want a alertview we set the $output variable
			$this::$output = $output;
		}

		protected function getOutput() : array 
		{
			return $this::$output;
		}
	}
?>