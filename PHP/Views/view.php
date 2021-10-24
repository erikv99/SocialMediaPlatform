<?php 

	/** View base class */

	class View 
	{
		/* Variable contains the html/content of the view */
		private string $viewContent;

		function __construct() 
		{
			$this->viewContent = "<h1>View->viewContent is not set</h1>";
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
			return $this->viewContent;
		}
	}
?>