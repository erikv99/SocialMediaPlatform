<?php  

require_once("view.php");

/**
 * View class for the admin page
 */
class AdminView extends View 
{
	/**
	 * Function which makes/creates the actual view. (the specific to this page part)
	 * 
	 * @param array $modelOutput
	 * @return string $view
	 */
	protected function createView(array $modelOutput) : string
	{
		$secondarySubjects = $modelOutput["secondarySubjects"];
		$primarySubjects = $modelOutput["primarySubjects"];
		$subjects = $modelOutput["subjects"];
		$primaryListBoxView = $this->getRemovePrimarySubView($primarySubjects);
		$getSecondaryListBoxView = $this->getRemoveSecondarySubView($primarySubjects, $secondarySubjects);

		$view = $this->getAdminInfoView();
		$view .= $this->getRemovePrimarySubView($primarySubjects);
		$view .= $this->getRemoveSecondarySubView($primarySubjects, $secondarySubjects);

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

	/**
	 * Gets the admin info subject container view
	 * 
	 * @return string $view
	 */
	private function getAdminInfoView() : string
	{
		$view = 
		"<div class='subjectContainer'>
			<table>
				<tr class='subjectContainerHeaderRow'><td><p class='subjectContainerHeaderTitle'>
				Admin
				</p></td></tr>
				
				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				<i class='fas fa-info-circle'></i> To accept or reject a subject proposal visit the <b><a onclick='callController(\".content\", \"proposalController\")'>proposals page</a></b>
				</p><td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				<i class='fas fa-info-circle'></i> To edit or delete any post just go to that post and the options will be available.
				</p><td></tr>
			</table>
		</div>";

		return $view;
	}

	/**
	 * Gets the remove primary subject container view
	 * 
	 * @param array $primarySubjects
	 * @return $view
	 */
	private function getRemovePrimarySubView($primarySubjects) : string
	{
		$primaryOptions = $this->getOptionsView($primarySubjects);
		$dataArg = "deletePrimary|\" + document.getElementById(\"primaryToDelete\").options[document.getElementById(\"primaryToDelete\").selectedIndex].value";

		$view = 
		"<div class='subjectContainer'>
			<table>
				<tr class='subjectContainerHeaderRow'><td><p class='subjectContainerHeaderTitle'>
				Delete primary subject
				<div class='SCHeaderRowSingleButton'>
					<button class='proposeButton button' onClick='callController(\".content\", \"adminController\", \"$dataArg);'>
						<i class='fas fa-eraser'></i> Delete
					</button>
				</div>
				</p></td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'>
				<label class='listboxLabel'>Select primary</label> 
				<select id='primaryToDelete' class='listBox'>
				" . $primaryOptions . "
				</select><td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				<i class='fas fa-info-circle'></i> Deleting a primary subject will result in deletion of <b>all secondary subjects, proposals and posts</b> under this primary subject.
				</p><td></tr>

			</table>
		</div>";

		return $view;
	}

	/**
	 * Gets the remove secondary subject container view
	 * 
	 * @param array $primarySubjects
	 * @param array $secondarySubjects
	 * @return $view
	 */
	private function getRemoveSecondarySubView($primarySubjects, $secondarySubjects) : string
	{
		logDebug("primsubs: " . var_export($primarySubjects,true));
		$primaryOptions = $this->getOptionsView($primarySubjects);
		logDebug("secsubs: " . var_export($secondarySubjects,true));
		$secondaryOptions = $this->getOptionsView($secondarySubjects);
		$dataArg = "deleteSecondary|\" + document.getElementById(\"primaryToLoadSecondariesFrom\").options[document.getElementById(\"primaryToLoadSecondariesFrom\").selectedIndex].value + \"|\" + document.getElementById(\"secondaryToDelete\").options[document.getElementById(\"secondaryToDelete\").selectedIndex].value";

		$view = 
		"<div class='subjectContainer'>
			<table>
				<tr class='subjectContainerHeaderRow'><td><p class='subjectContainerHeaderTitle'>
				Delete secondary subject
				<div class='SCHeaderRowSingleButton'>
					<button class='proposeButton button' onClick='callController(\".content\", \"adminController\", \"$dataArg);'>
						<i class='fas fa-eraser'></i> Delete
					</button>
				</div>
				</p></td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'>
				<label class='listboxLabel'>Select primary</label> 
				<select id='primaryToLoadSecondariesFrom' class='listBox' onchange='loadSecondaries();'>
				" . $primaryOptions . "
				</select><td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'>
				<label class='listboxLabel'>Select secondary</label>
				<select id='secondaryToDelete' class='listBox'>
				" . $secondaryOptions . "
				</select></td></tr>

				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				<i class='fas fa-info-circle'></i> Deleting a secondary subject will result in deletion of <b>all posts </b> under this secondary subject.	
				</p><td></tr>

			</table>
		</div>";

		return $view;
	}

	/**
	 * Will return the given array of string as a view that can be placed in a <select> statement as a listbox
	 * 
	 * @param array $arrayOfStrings
	 * @return string $view
	 */
	private function getOptionsView(array $arrayOfStrings) : string
	{
  		$view = "";

		for ($i = 0; $i < count($arrayOfStrings); $i++) 
		{
			$view .= "<option value='" . $arrayOfStrings[$i] .  "'>" . $arrayOfStrings[$i] . "</option>";
  		}

  		return $view;
	}
}
?>