<?php  
require_once("view.php");

class PostPageView extends View 
{
	private function createView(array $modelView) : string 
	{
		$view = "PostPageView";
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