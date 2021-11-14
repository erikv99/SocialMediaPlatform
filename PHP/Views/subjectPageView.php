<?php  
require_once("../Views/view.php");

class SubjectPageView extends View 
{
	protected function createView() 
	{
		$this::$viewContent = 
		"
		<div class='subjectContainer'>
			<table>
				<tr><td class='primarySubjectTitle'><p>" . "test" . "</p></td></tr>
			</table>
		</div>
		";
	}

	public function getView() : string 
	{
		$this->createView();
		return Parent::getViewContent();
	}

}
?>