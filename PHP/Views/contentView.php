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
			//die(var_export($subjects, true));
			$secondarySubjectArr = $subjects[$primarySubjects[$i]];
			logError("secsubarr: " . var_export($secondarySubjectArr, true));
			$secondarySubjectView = "";

			// Looping through all the secondary subjects
			for ($j = 0; $j < count($secondarySubjectArr); $j++) 
			{
				// Adding a secondarySubject view for each secondary subject
				$secondarySubjectView .= '
				<tr>
					<td class="secondarySubjectTitle">
						<p><a href="#SubSubject"> ' . $secondarySubjectArr[$j] . '</a></p>
					</td>
				</tr>';
			}

			// Making the subject view (current primarysubject with all its secondarysubject)
			$subjectView = 
			'<div class="subjectContainer">
			<table>
				<tr>
					<td id="subjectContainer' . $primarySubjects[$i] . '" class="primarySubjectTitle">
						<p>' . $primarySubjects[$i] . '</p>
						<button class="imageButton collapseSubjectButton">
							<img class="collapseSubjectImg" src="../IMG/collapse.png">
						</button>
					</td>
				</tr>
				' . $secondarySubjectView . '
			</table>
			</div>';

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