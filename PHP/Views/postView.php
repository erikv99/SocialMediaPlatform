<?php  
require_once("view.php");

class PostView extends View 
{
	private function createView(array $modelView) : string 
	{
		$view = "postview";
		return $view;
	}

	public function getView() : string 
	{
		// Updating the view
		$this::$viewContent = $this->createView($this::$output);

		// Returning the view
		return Parent::getViewContent();
	}
}
?>