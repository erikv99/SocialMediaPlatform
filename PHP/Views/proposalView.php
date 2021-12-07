<?php  
require_once("view.php");
require_once("../Objects/post.php");

class ProposalView extends View 
{
	protected function createView(array $modelOutput) : string 
	{
		$view = "
		<div class='subjectContainer'>
		<table>
			<tr class='subjectContainerHeaderRow'><td>
			<p class='postTitle'>Primary subject proposal</p>
			<div class='SCHeaderRowSingleButton'>
			<button class='proposeButton button'><i class='far fa-lightbulb'></i> Propose</button>
			</div>
			</td></tr>
			<tr class='subjectContainerContentRow'><td class='subjectContainerSubRowTD'>
			<label class='proposalLabel'>Subject: </label><input type='text' class='proposalInput' placeholder='Enter subject title'/></td></tr>
			<tr class='subjectContainerContentRow'><td class='subjectContainerSubRowTD'>
			<label class='proposalLabel'>Reason: </label><textarea type='text' rows='2' class='proposalInput' placeholder='Enter reason subject should be added'/>
			</td></tr>
		</table>
		</div>
		";

		return $view;
	}

	public function getView() : string 
	{
		// Updating the view
		$this::$viewContent = $this->createView($this::$output);

		// Returning the view
		return Parent::getViewContent();
	}
}
?>