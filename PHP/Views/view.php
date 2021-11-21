<?php 
	require_once("../generalFunctions.php");
	require_once("alertView.php");
	require_once("locationBarView.php");

	/** View base class */
	abstract class View 
	{
		/* Variable contains the html/content of the view */
		static protected string $viewContent = "";

		// These variables are static so their state remains the same between calls
		static protected array $output = [];

		// Function which creates the view specific to the type of view
		abstract protected function createView(array $modelOutput) : string;

		/**
 		* Creates the view and returns it
 		* 
 		* @param array $modelView
 		* @return string $view
 		*/
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

			// Returning either only the alertview or view + alertview (can be empty or not)
			if (isset($output["getAlertOnly"])) 
			{
				if ($output["getAlertOnly"] == true) 
				{
					return $this->getAlertView();
				}
			}

			// Making a new locationbar object
			$locationBar = new LocationBarView();

			// Checking if the field "locations" exists/is set.
			if (isset($output["locations"])) 
			{
				// Setting the locations for the locationBar
				$locationBar->setLocations($output["locations"]);
			}

			logDebug("locationbar->getview = " . var_export($locationBar->getView(),true));
			// Returning the view. prepended by the locationbar view and containing the $alertview at the end. 
			// If locationBar is not specifically set it will contain just a link to the homepage.
			// If alertView  is not set it will contain a empty string
			return $locationBar->getView() . $this::$viewContent . $this->getAlertView();
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
				$alertViewObj = new ALertView($output["messageType"], $output["message"]);
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