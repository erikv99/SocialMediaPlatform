<?php

require_once("../Views/view.php");

class ContentView extends View 
{
	public function __construct()
	{
		$this->view = new View();
	}

	private function createView() 
	{
		$subjects = $this->view->getOutput()["subjects"];
		$primarySubjects = array_keys($subjects);
		$viewToSet = "";

		// Looping thru each primarySubject
		for ($i = 0; $i < count($primarySubjects); $i++) 
		{
			$secondarySubjectArr = $subjects[$primarySubjects[$i]];
			$secondarySubjectView = "";

			// Looping through all the secondary subjects
			for ($j = 0; $j < count($secondarySubjectArr); $j++) 
			{
				// Adding a secondarySubject view for each secondary subject
				$secondarySubjectView .= "
				<tr class='secondarySubjectRow'>
					<td class='secondarySubjectTitle'>
						<p><a onclick='callController(\".content\", \"subjectPageController\", \"" . $secondarySubjectArr[$j] . "\")'> " . $secondarySubjectArr[$j] . "</a></p>
					</td>
				</tr>";
			}

			// Making the subject view (current primarysubject with all its secondarysubject)
			$subjectView = 
			"<div class='subjectContainer' id='subjectContainer" . $primarySubjects[$i] . "' >
			<table>
				<tr>
					<td class='primarySubjectTitle'>
						<p><a onclick='callController(\".content\", \"subjectPageController\", \"" . $primarySubjects[$i] . "\")'><i class='fas fa-book'></i> " . $primarySubjects[$i] . "</a></p>
						<button class='imageButton collapseSubjectButton' onClick='collapseSubject(\"#subjectContainer" . $primarySubjects[$i] . "\");'>
							<img class='collapseSubjectImg' src='../IMG/collapse.png'>
						</button>
					</td>
				</tr>
				" . $secondarySubjectView . "
			</table>
			</div>";

			// Adding the current subjectContainer to the view we want to set
			$viewToSet .= $subjectView;
		}

		$this->view->setView($viewToSet);
	}

	public function getView() : string 
	{
		$this->createView();
		return $this->view->getView();
	}
}
?>