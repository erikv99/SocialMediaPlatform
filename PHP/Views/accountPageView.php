<?php  

require_once("view.php");

/**
 * View class for the account page (private/public)
 */
class AccountPageView extends View 
{
	/**
	 * Function which makes/creates the actual view. (the specific to this page part)
	 * 
	 * @param array $modelOutput
	 * @return string $view
	 */
	protected function createView(array $modelOutput) : string
	{
		$viewType = $modelOutput["viewType"];
		$containerTitle = "";
		$username = $modelOutput["username"];
		$amountOfPosts = $modelOutput["amountOfPosts"];
		$creationDate = $modelOutput["creationDate"];
		$creditBalance = $modelOutput["creditBalance"];

		if ($viewType == "normal") 
		{
			$containerTitle = $username . "'s account";
		}
		elseif ($viewType == "owner") 
		{
			$containerTitle = "My account";
		}

		$view =
		"
		<div class='subjectContainer'>
			<table>
				<tr class='subjectContainerHeaderRow'><td><p class='subjectContainerHeaderTitle'>
				$containerTitle
				</p></td></tr>
				
				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				<i class='fas fa-user-tie'></i> Username: <b>$username</b>
				</p><td></tr>
				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				<i class='far fa-lightbulb'></i> Posts created: <b>$amountOfPosts</b>
				</p></td></tr>
				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				<i class='fas fa-money-check-alt'></i> Credit balance: <b>$creditBalance</b>
				</p></td></tr>
				<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='basicPageText'>
				<i class='far fa-calendar-alt'></i> Account creation date: <b>$creationDate</b>
				</p></td></tr>
			</table>
		</div>
		";

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
}
?>