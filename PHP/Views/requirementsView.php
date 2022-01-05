<?php  

require_once("view.php");

/**
 * View class for the requirements page
 */
class RequirementsView extends View 
{
	/**
	 * Function which makes/creates the actual view. (the specific to this page part)
	 * 
	 * @param array $modelOutput
	 * @return string $view
	 */
	protected function createView(array $modelOutput) : string
	{
		$view = "		
		<div class='subjectContainer'>
			<table>
				<tr class='subjectContainerHeaderRow'><td><p class='subjectContainerHeaderTitle'>
				Requirements
				</p></td></tr>
				
				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				<b>This page contains any requirements of which i'm not certain I (properely) handled throughout the project.</b>
				</p><td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'>
				<p class='basicPageText'><b>Implicit casting</b></p>
				<p class='basicPageText'>Implicit casting is when the compiler casts a variable to a different type if it deems it necessary.</p>
				<p class='basicPageText'>A example of this is 2/4 which comes down to 0.5, so even tho we divide two integers the result is going to be a float due to implicit casting</p>
				<td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'>
				<p class='basicPageText'><b>Explicit casting</b></p>
				<p class='basicPageText'>Implicit casting is when you tell the compiler which data type the variable should be converted to</p>
				<p class='basicPageText'>A example of this is the following \$a = 5.35, \$b = (int) \$a. In this case we tell the compiler that \$b should be a integer </p>
				<td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'>
				<p class='basicPageText'><b>Do while</b></p>
				<p class='basicPageText'>The do while loop is pretty much similair to a normal while loop except for the fact that it while execute the block of code atleast once.</p>
				<p class='basicPageText'>This is because it will execute the code once and then continue to check to condition of the loop.</p>
				<td></tr>


			</table>
		</div>";

		return $view;
	}

	/**
	 * Function for getting the view
	 * 
	 * @return string $view
	 */	
	public function getView() : string
	{
		// Updating the view
		$this::$viewContent = $this->createView($this::$output);

		// Returning the view
		return Parent::getViewContent();
	}
}
?>