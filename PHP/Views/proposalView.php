<?php  
require_once("view.php");
require_once("../Objects/post.php");

class ProposalView extends View 
{
	protected function createView(array $modelOutput) : string 
	{
		$primarySubjectOptions = $this->getPrimarySubjectsOptionsView($modelOutput["primarySubjects"]);
		
		$proposePrimaryDataArg =  "proposePrimary,\" + document.getElementById(\"primProposalTitle\").value + \",\" + document.getElementById(\"primProposalReason\").value";
		$proposeSecondaryDataArg = "proposeSecondary,\" + document.getElementById(\"secProposalTitle\").value + \",\" + document.getElementById(\"secProposalReason\").value + \",\" + document.getElementById(\"selectPrimarySubject\").options[document.getElementById(\"selectPrimarySubject\").selectedIndex].value";

		$view = "
		<div class='subjectContainer'>
		<table>
			<tr class='subjectContainerHeaderRow'><td>
			<p class='postTitle'>Primary subject proposal</p>
			<div class='SCHeaderRowSingleButton'>
			<button class='proposeButton button' onClick='callController(\".content\", \"proposalController\", \"$proposePrimaryDataArg);'><i class='far fa-lightbulb'></i> Propose</button>
			</div>
			</td></tr>
			<tr class='subjectContainerContentRow'><td class='subjectContainerSubRowTD'>
			<label class='proposalLabel'>Subject: </label><input type='text' class='proposalInput' id='primProposalTitle' placeholder='Enter subject title'/></td></tr>
			<tr class='subjectContainerContentRow'><td class='subjectContainerSubRowTD'>
			<label class='proposalLabel'>Reason: </label><textarea type='text' rows='2' class='proposalInput proposalTextArea' id='primProposalReason' placeholder='Enter reason subject should be added'/>
			</td></tr>
		</table>
		</div>

		<div class='subjectContainer'>
		<table>
			<tr class='subjectContainerHeaderRow'><td>
			<p class='postTitle'>Secondary subject proposal</p>
			<div class='SCHeaderRowSingleButton'>
			<button class='proposeButton button' onClick='callController(\".content\", \"proposalController\", \"$proposeSecondaryDataArg);'><i class='far fa-lightbulb'></i> Propose</button>
			</div>
			</td></tr>
			<tr class='subjectContainerContentRow'><td class='subjectContainerSubRowTD'>
				<label class='proposalLabel'>Primary subject: </label>
				<select class='proposalListBox' id='selectPrimarySubject'>
				" . $primarySubjectOptions . "
				</select>
			</td></tr>
			<tr class='subjectContainerContentRow'><td class='subjectContainerSubRowTD'>
			<label class='proposalLabel'>Subject: </label><input type='text' class='proposalInput' id='secProposalTitle' placeholder='Enter subject title'/></td></tr>
			<tr class='subjectContainerContentRow'><td class='subjectContainerSubRowTD'>
			<label class='proposalLabel'>Reason: </label><textarea type='text' rows='2' class='proposalInput proposalTextArea' id='secProposalReason' placeholder='Enter reason subject should be added'/>
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

	/**
	 * Will get/make the view for the listbox containing all the primarySubjects.
	 * 
	 * @param array $primarySubjects
	 * @return string $optionsView
	 */
	private function getPrimarySubjectsOptionsView(array $primarySubjects) : string 
	{
		$view = "";

		for ($i = 0; $i < count($primarySubjects); $i++) 
		{
			$view .= "<option value='" . $primarySubjects[$i] .  "'>" . $primarySubjects[$i] . "</option>";
		}

		return $view;
	}
}
?>