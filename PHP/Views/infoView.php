<?php  

require_once("view.php");

/**
 * View class for the home page
 */
class InfoView extends View 
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
				Info
				</p></td></tr>
				
				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				<b>What are credits?</b> 
				</p><td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				Currently users earn 10 credits for creating a posts. The're currently no ways to spend your credits
				</p><td></tr>
				
				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				<b>Why do i see small white lines in the container design?</b> 
				</p><td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				The site was developed in Firefox and may display small design problems in other browsers. These are know and will soon be patched.
				</p><td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				<b>Planned features</b> 
				</p><td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				The following features are planned to be implemented in the upcoming months.
				<ol>
					<li>A way in which a user can use credits</li>
					<li>Further admin functionality</li>
					<li>Comment sections</li>
					<li>Image support for posts</li>
				</ol>
				</p></td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				<b>API</b> 
				</p><td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				The ThoughtShare RESTful API can be accesed by adding the following to the end of the URL.
				</p><td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				To get all users add <b>/api/users</b> (example: www.thoughtshare.com/api/users)
				</p><td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				To get a specific user add <b>/api/user/username</b> (example: www.thoughtshare.com/api/user/erik)
				</p><td></tr>

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