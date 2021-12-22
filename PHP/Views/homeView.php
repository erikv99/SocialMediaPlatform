<?php  

require_once("view.php");

/**
 * View class for the home page
 */
class HomeView extends View 
{
	/**
	 * Function which makes/creates the actual view. (the specific to this page part)
	 * 
	 * @param array $modelOutput
	 * @return string $view
	 */
	protected function createView(array $modelOutput) : string
	{
		$view =
		"
		<div class='subjectContainer'>
			<table>
				<tr class='subjectContainerHeaderRow'><td>
				<p class='homeTitle'>Welcome to ThoughtShare!</p>
				</td></tr>
				
				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'>
				<img class='quoteIMG' src='../IMG/quote.jpg'></img>
				<td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='homeText'>
				<br/>
				Thoughtshare is the place where you can share your thoughts on your favourite subjects!
				</p><td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='homeText'>
				<a onclick='callController(\".content\", \"contentController\");'><b>Explore</b></a> our large variety of subjects or <a onclick='callController(\".content\", \"proposalController\");'><b>propose</b></a> your own subject
				</p><td></tr>



			</table>
		</div>
		";

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