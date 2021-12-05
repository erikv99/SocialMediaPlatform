<?php 

require_once("../generalFunctions.php");
require_once("../Exceptions/databaseException.php");
require_once("../Exceptions/customException.php");

/** Model base class */
abstract class Model
{
	// This functions executes the model logic.
	abstract protected function execute() : array;

	/**
	 * Function to check if the given username is already present in the user table in the database
	 * function is placed in the model base since it is used more then once
	 * 
	 * @return bool doesUserExist
	 */
	protected function usernameExists(string $username) 
	{
		// Opening a DB connection and checking if the given username is present in our data table
		$dbConnection = openDBConnection();

		try 
		{
			$stmt = $dbConnection->prepare("SELECT COUNT(userName) FROM users WHERE userName = ?");
			$stmt->execute([$username]);
			$output = $stmt->fetch()["COUNT(userName)"];
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());

		}

		// If the username is present $doesUserExist will be true otherwise it shall be false.
		$doesUserExist = ($output > 0) ? true : false;

		// Closing the DB connection and returning the result
		closeDBConnection($dbConnection);
		return $doesUserExist;
	}

	/**
	 * Function which checks if the data variable in the post request is empty or not. 
	 *
	 * @return bool isPostDataEmpty
	 */
	protected function isPostDataEmpty() 
	{
		$returnVal = $_POST["data"] == "" ? true : false;
		return $returnVal;
	}

	/**
	 * Function checks if the postFormData is empty or not, intended for login/register only.
	 * 
	 * $return bool isPostFormDataEmpty
	 */
	protected function isPostFormDataEmpty() 
	{
		$returnVal = !isset($_POST["username"]) ? true : false;
		return $returnVal;
	}
}
?>