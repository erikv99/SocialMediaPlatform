<?php 
/**
 * Custom PDO exception
 */

require_once("../generalFunctions.php");

class DBException extends Exception 
{
	// Redefining the constructor
	public function __construct($message, $code = 0, Throwable $previous = null) 
	{	
		// Logging the error	
		logError("Database error occured in file " . $this->file . " on line " . $this->line . "\nError: " . $message);

		// Calling parent constructor
		parent::__construct($message, $code, $previous);

		// Sending back the javascript which will invoke the callController for alerts which will display a basic error alert.
		echo json_encode(["view" => "<script type='text/javascript'>callController(\"body\", \"alertController\");</script>"]);
		die();
	}


}
?>

