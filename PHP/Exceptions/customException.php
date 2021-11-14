<?php 
/**
 * Custom exception which also logs the error properely
 */

require_once("../generalFunctions.php");

class CustomException extends Exception 
{
	// Redefining the constructor
	public function __construct($message, $code = 0, Throwable $previous = null) 
	{
		
		// Logging the error	
		logError("Error occured in file " . $this->file . " on line " . $this->line . "\nError: " . $message);

		// Calling parent constructor
		parent::__construct($message, $code, $previous);
	}
}
?>