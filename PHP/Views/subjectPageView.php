<?php  
require_once("../Views/view.php");

class SubjectPageView extends View 
{
	private View $view;

	public function __construct()
	{
		$this->view = new View();
		$this->createView();
	}

	private function createView() 
	{
		$this->view->setView("
		<div class='subjectContainer'>
			<table>
				<tr><td class='primarySubjectTitle'><p>" . "test" . "</p></td></tr>
			</table>
		</div>

			
		");
	}

	public function getView() : string 
	{
		$this->createView();
		return $this->view->getView();
	}

}
?>