<?php  
require_once("view.php");

class SecondarySubjectView extends View 
{
	/**
	 * Creates the view for us to return
	 */
	protected function createView()
	{
		// Getting the output stored in the view.
		$output = $this::$output;

		


	}

	/**
	 * Returns the view for this MVC
	 * 
	 * @return string $view
	 */
	public function getView() : string 
	{
		$this->createView();
		return Parent::getViewContent();
	}
}
?>