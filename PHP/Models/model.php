<?php 

/** Model base class */

class Model
{
	public function __construct()
	{

	}

	/**
	 * Function which will execute the logic inside the model class. since this function is always being called it must have a return value.
	 * 
	 * @return "" is no error
	 * @return "errorMessage" if a error is found
	 */
	public function execute() 
	{
		return "";
	}

}
?>