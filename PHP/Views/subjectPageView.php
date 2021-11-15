<?php  
require_once("../Views/view.php");

class SubjectPageView extends View 
{
	protected function createView() 
	{
		$output = $this->getOutput();
		$secondarySubjects = $output["secondarySubjects"];

		$this::$viewContent = 
		"
		<div class='subjectContainer subjectPageTitle'>
			<table>
				<tr><td class=''><p>" . $output["primarySubject"] . "</p></td></tr>
			</table>
		</div>
		";

		for ($i = 0; $i < count($secondarySubjects); $i++) 
		{
			$this::$viewContent .= 
			"
			<div class='subjectContainer'>
				<table>
					<tr class='secondarySubjectRow'><td class='secondarySubjectTitle'><p>" . $secondarySubjects[$i] . "</p></td></tr>
				</table>
			</div>
			";
		}
	}

	public function getView() : string 
	{
		$this->createView();
		return Parent::getViewContent();
	}

}
?>