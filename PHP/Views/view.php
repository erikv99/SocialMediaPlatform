<?php 
	require_once("../generalFunctions.php");
	require_once("alertView.php");

	/** View base class */
	abstract class View 
	{
		/* Variable contains the html/content of the view */
		static protected string $viewContent = "";

		// These variables are static so their state remains the same between calls
		static private array $output = [];

		// Function which creates the view specific to the type of view
		abstract protected function createView();

		// Function which returns the view 
		abstract public function getView();

		/**
		 * Function which will return the view
		 * 
		 * There are 2 options.
		 * Getting just the normal view + alertview (filled if set empty if not set)
		 * Getting only the alertview
		 * 
		 * @return correct view depending on the situation.
		 */
		public function getViewContent() 
		{
			$output = $this::$output;
			$alertView = $this->getAlertView();

			// Returning either only the alertview or view + alertview (can be empty or not)
			if (isset($output["getAlertOnly"])) 
			{
				if ($output["getAlertOnly"] == true) 
				{
					logDebug("returnalertonly = yes\n alertview = " . var_export($alertView, true));
					return $alertView;
				}
			}

			return $this::$viewContent . $alertView;
		}

		public function setOutput($output) 
		{
			$this::$output = $output;
		}

		public function getOutput() : array 
		{
			return $this::$output;
		}

		private function getAlertView()
		{
			$output = $this::$output;

			// Checking if the view requires a alert or not
			if (isset($output["messageType"]) and isset($output["message"]))
			{	
				// Getting the view of the alert
				$alertViewObj = new ALertView();
				$alertViewObj->createView($output["messageType"], $output["message"]);
				$alertView = $alertViewObj->getView();
				return $alertView;
			}
			else 
			{
				return "";
			}

		}
	}
?>