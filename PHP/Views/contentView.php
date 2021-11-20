<?php

require_once("../Views/view.php");

class ContentView extends View 
{
	protected function createView(array $modelOutput) : string 
	{
		// Getting the subjects from our modelOutput.
		$subjects = $modelOutput["subjects"];

		// Getting the primary subjects by getting the array_keys (prim subs)
		$primarySubjects = array_keys($subjects);
		$view = "";

		// Looping thru each primarySubject
		for ($i = 0; $i < count($primarySubjects); $i++) 
		{	
			$primarySubject = $primarySubjects[$i];

			// Getting the array containing all the secondarysubjects for the current primarysubject
			$secondarySubjectsArr = $subjects[$primarySubject];
			
			// Getting the table row views for the secondary subjects for the current primarysubject
			$secondarySubjectsRowView = $this->getSecondarySubjectsRowView($secondarySubjectsArr, $primarySubject);

			// Getting the subjectContainer view for the current subject.
			$subjectView = $this->getSubjectView($primarySubject, $secondarySubjectsRowView);

			// Adding the current subjectContainer to the view
			$view .= $subjectView;
		}

		return $view;
	}

	private function getSubjectView($primarySubject, $secondarySubjectsRowView) 
	{
		// Making the subject view (current primarysubject with all its secondarysubject)
		$view = 
		"<div class='subjectContainer subjectContainer" . $primarySubject . "' >
		<table>
			<tr class='subjectContainerHeaderRow'>
				<td>
					<p class='subjectContainerHeaderTitle'>
						<a onclick='callController(\".content\", \"primarySubjectController\", \"" . $primarySubject . "\")'><i class='fas fa-book'></i> " . $primarySubject . "</a>
					</p>
					<button class='imageButton collapseSubjectButton' onClick='collapseSubject(\".subjectContainer" . $primarySubject . "\");'>
						<img class='collapseSubjectImg' src='../IMG/collapse.png'>
					</button>
				</td>
			</tr>
			" . $secondarySubjectsRowView . "
		</table>
		</div>";

		return $view;
	}

	private function getSecondarySubjectsRowView($secondarySubjectsArr, $primarySubject) 
	{
		$view = "";

		// Looping through all the secondary subjects in the array
		for ($i = 0; $i < count($secondarySubjectsArr); $i++) 
		{
			// Adding a secondarySubject view for each secondary subject
			$view .= $this->getSecondarySubjectRowView($secondarySubjectsArr[$i], $primarySubject);
		}

		return $view;
	}

	private function getSecondarySubjectRowView($secondarySubject, $primarySubject) 
	{
		$view = 
		"<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'>
				<p class='subjectContainerSubTitle'><a onclick='callController(\".content\", \"secondarySubjectController\", \"" . $primarySubject . "," . $secondarySubject . "\")'> " . $secondarySubject . "</a></p>
			</td>
		</tr>";

		return $view;
	}

	public function getView() : string 
	{
		$this::$viewContent = $this->createView($this::$output);
		return Parent::getViewContent();
	}
}
?>