<?php 
require_once("../Views/view.php");

class RegisterView extends View 
{	
	function __construct() 
	{
		// Calling the parent constructor
		parent::construct();
	}
	
	function getView() 
	{
		return "<h1>Hello World</h1>";
	}
}
?>