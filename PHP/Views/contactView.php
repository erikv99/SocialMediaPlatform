<?php  
require_once('view.php');

/**
 * View class for the contact page 
 */
class ContactView extends View 
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
				Contact
				</p></td></tr>
				
				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				At thoughtshare we appreciate our customers, please don't hesitate to reach out to us.
				</p><td></tr>
				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				Email us at thoughtshare@gmail.com
				</p></td></tr>
				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				Call us at +316 12345678
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