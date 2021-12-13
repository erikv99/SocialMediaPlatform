<?php

require_once("view.php");

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
			$subjectView = $this->getSubjectView($primarySubject, $secondarySubjectsRowView, $i);

			// Adding the current subjectContainer to the view
			$view .= $subjectView;
		}

		return $view;
	}

	/**
	 * Makes amd returns the view for 1 specific primary subject
	 * 
	 * @param string $primarySubject
	 * @param string $secondarySubjectRowView
	 * @param int $idNum
	 * @return string $view
	 */
	private function getSubjectView(string $primarySubject, string $secondarySubjectsRowView, int $idNum) : string
	{
		$escapedPrimSub = htmlspecialchars($primarySubject, ENT_QUOTES);

		// Making the subject view (current primarysubject with all its secondarysubject)
		$view = 
		"<div class='subjectContainer subjectContainer" . $idNum . "' >
		<table>
			<tr class='subjectContainerHeaderRow'>
				<td>
					<p class='subjectContainerHeaderTitle'>
						<a onclick='callController(\".content\", \"primarySubjectController\", \"" . $escapedPrimSub . "\")'><i class='fas fa-book'></i> " . $primarySubject . "</a>
					</p>
					<div class='SCHeaderRowSingleButton'>
					<button class='imageButton SCHeaderRowButton' onClick='collapseSubject(\".subjectContainer" . $idNum . "\");'>
						<img class='SCHeaderRowButtonImg' src='../IMG/collapse.png'>
					</button>
					</div>
				</td>
			</tr>
			" . $secondarySubjectsRowView . "
		</table>
		</div>";

		return $view;
	}

	/**
	 * Takes a array of secondary subjects and returns a array containing all the secondary subjects in a view.
	 * 
	 * @param array $secondarySubjectArr
	 * @param string $primarySubject
	 * @return string $view
	 */
	private function getSecondarySubjectsRowView(array $secondarySubjectsArr, string $primarySubject) : string
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

	/**
	 * Gets and and returns the view for 1 specific secondary subject. 
	 * @param string $secondarySubject
	 * @param string $primarySubject
	 * @return string $view
	 */
	private function getSecondarySubjectRowView(string $secondarySubject, string $primarySubject) : string 
	{
		$dataArg = $primarySubject . "|" . $secondarySubject;
		$dataArg = htmlspecialchars($dataArg, ENT_QUOTES | ENT_HTML5, 'UTF-8');

		$view = 
		"<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'>
				<p class='subjectContainerSubTitle'><a onClick='callController(\".content\", \"secondarySubjectController\", \"" . $dataArg . "\");'> " . $secondarySubject . "</a></p>
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