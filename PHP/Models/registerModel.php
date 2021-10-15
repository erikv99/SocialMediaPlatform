<?php 
require_once("../Views/registerView.php");
require_once("../Models/model.php");

class RegisterModel extends Model  
{
	function test() 
	{
	Model::assignVariable("varA", "blaA");
	Model::deleteVariable("varA");

	}

}
?>