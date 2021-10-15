<?php 
class Model
{
	private $variables = array();

	// The following functions are for assigning, updating and deleting private variables in the model class. (private since there in a private array/list)
	protected function assignVariable(string $varName, $varValue)
	{
		//global $variables;
		$this->variables[$varName] = $varValue;
	}

	protected function deleteVariable(string $varName) 
	{
		//global $variables;
		$index = array_search($varName, $this->variables);
		unset($this->variables[$index]);
	}

}
?>