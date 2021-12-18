<?php  

require_once("view.php");

class AccountPageView extends View 
{
	/**
	* Creates the view and returns it
	* 
	* @param array $modelView
	* @return string $view
	*/
	protected function createView(array $modelView) : string
	{
		$view =
		"
		<div class='subjectContainer'>accountPage</div>
		";

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