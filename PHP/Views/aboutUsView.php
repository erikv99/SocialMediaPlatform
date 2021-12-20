<?php  
require_once('view.php');

/**
 * View class for the about us page 
 */
class AboutUsView extends View 
{
	/**
	 * Function which makes/creates the actual view. (the specific to this page part)
	 * 
	 * @param array $modelOutput
	 * @return string $view
	 */
	public function createView(array $modelOutput) : string
	{
		$view = "		
		<div class='subjectContainer'>
			<table>
				<tr class='subjectContainerHeaderRow'><td><p class='subjectContainerHeaderTitle'>
				About us
				</p></td></tr>
				
				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				Thoughtshare was founded in 2021 as school project. 
				</p><td></tr>
				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				It was founded by Erik V. and contains no frameworks as per school requirements.
				</p></td></tr>
			</table>
		</div>";

		return $view;
	}

	/**
	 * Gets the view and returns it
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