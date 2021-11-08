<?php

require_once("../Views/view.php");

class ContentView extends View 
{
	public function __construct()
	{
		$this->view = new View();
	}

	public function getView() : string 
	{
		return $this->view->getView();
	}
}
?>