<?php  
require_once("view.php");
require_once("../Objects/post.php");

class ProposalView extends View 
{
	protected function createView(array $modelOutput) : string 
	{
		$primarySubjectOptions = $this->getPrimarySubjectsOptionsView($modelOutput["primarySubjects"]);
		
		$proposePrimaryDataArg =  "proposePrimary|\" + document.getElementById(\"primProposalTitle\").value + \"|\" + document.getElementById(\"primProposalReason\").value";
		$proposeSecondaryDataArg = "proposeSecondary|\" + document.getElementById(\"secProposalTitle\").value + \"|\" + document.getElementById(\"secProposalReason\").value + \"|\" + document.getElementById(\"selectPrimarySubject\").options[document.getElementById(\"selectPrimarySubject\").selectedIndex].value";

		$view = "";

		// Checking if viewType requested is 'admin'
		if ($modelOutput["viewType"] == "admin") 
		{
			// Adding the admin part of the view to the regular part.
			$view .= $this->getAdminView();
		}

		$view .= "
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

	/**
	 * Returns the part of the view that is for admins only 
	 * 
	 * @return string $adminView
	 */
	private function getAdminView() : string 
	{
		$primaryProposalsView = $this->getPrimaryProposalsView();
		$secondaryProposalsView = $this->getSecondaryProposalsView();
		$view = $primaryProposalsView . $secondaryProposalsView;
		return $view;
	}

	/**
	 * Gets all the primary proposals from the database then puts them in a view
	 * 
	 * @return string $primaryProposalsView
	 */
	private function getPrimaryProposalsView() : string
	{
		$primaryProposals = [];
		$dbConnection = openDBConnection();

		try 
		{
			$stmt = $dbConnection->prepare("SELECT * FROM primaryproposals");
			$stmt->execute();
			$primaryProposals = $stmt->fetchAll();
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());

		}

		// Closing the DB connection
		closeDBConnection($dbConnection);

		$view = "
		<div class='subjectContainer primaryProposals'>
		<table>
			<tr class='subjectContainerHeaderRow'><td>
			<div class='SCHeaderRowSingleButton'>
				<button class='imageButton SCHeaderRowButton' onClick='collapsePrimaryProposals();'>
					<img class='SCHeaderRowButtonImg' src='../IMG/collapse.png'>
				</button>
			</div>
			<p class='postTitle'>Primary subject proposals</p>
			</td></tr>";

		// Looping thru all the primary proposals
		for ($i = 0; $i < count($primaryProposals); $i++) 
		{
			// Formatting the proposal date.
			$proposalDate = date_format(date_create($primaryProposals[$i]["proposalDate"]), "d-m-y");
			
			$title = htmlspecialchars($primaryProposals[$i]["proposalTitle"], ENT_QUOTES);
			//$title = $primaryProposals[$i]["proposalTitle"];
			$rejectDataArg = "rejectProposal|$title|primary";
			$approveDataArg = "approveProposal|$title|primary";

			$view .= "
			<tr class='subjectContainerContentRow'><td class='subjectContainerSubRowTD'>
			<div class='proposalReview'>
			<div class='proposalReviewButtons'>
				<i class='fas fa-times propReject' onClick='callController(\".content\", \"proposalController\", \"$rejectDataArg\");'></i>
				<i class='fas fa-check propApprove' onClick='callController(\".content\", \"proposalController\", \"$approveDataArg\");'></i>
			</div>
			<p>Proposed subject: <b>" . $primaryProposals[$i]["proposalTitle"] . "</b></p>
			<p>Proposed by user <b>" . $primaryProposals[$i]["proposalCreator"] . "</b> on " . $proposalDate . "</p>
			<p>Reason: " . $primaryProposals[$i]["proposalReason"] . "</p>
			</div></td></tr>
			";
		}

		$view .= "</table></div>";
		return $view;
	}

	/**
	 * Gets all the secondary proposals from the database then puts them in a view
	 * 
	 * @return string $secondaryProposalsView
	 */
	private function getSecondaryProposalsView() : string
	{
		$secondaryProposals = [];
		$dbConnection = openDBConnection();

		try 
		{
			$stmt = $dbConnection->prepare("SELECT * FROM secondaryproposals");
			$stmt->execute();
			$secondaryProposals = $stmt->fetchAll();
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());

		}

		// Closing the DB connection 
		closeDBConnection($dbConnection);
		
		$view = "
		<div class='subjectContainer secondaryProposals'>
		<table>
			<tr class='subjectContainerHeaderRow'><td>
			<div class='SCHeaderRowSingleButton'>
				<button class='imageButton SCHeaderRowButton' onClick='collapseSecondaryProposals();'>
					<img class='SCHeaderRowButtonImg' src='../IMG/collapse.png'>
				</button>
			</div>
			<p class='postTitle'>Secondary subject proposals</p>
			</td></tr>";

		// Looping thru all the secondary proposals
		for ($i = 0; $i < count($secondaryProposals); $i++) 
		{
			// Formatting the proposal date.
			$proposalDate = date_format(date_create($secondaryProposals[$i]["proposalDate"]), "d-m-y");
			
			$title = htmlspecialchars($secondaryProposals[$i]["proposalTitle"], ENT_QUOTES);
			$primary = htmlspecialchars($secondaryProposals[$i]["proposalPrimary"], ENT_QUOTES);
			$rejectDataArg = "rejectProposal|$title|secondary";
			$approveDataArg = "approveProposal|$title|secondary|$primary";

			$view .= "
			<tr class='subjectContainerContentRow'><td class='subjectContainerSubRowTD'>
			<div class='proposalReview'>
			<div class='proposalReviewButtons'>
				<i class='fas fa-times propReject' onClick='callController(\".content\", \"proposalController\", \"$rejectDataArg\");'></i>
				<i class='fas fa-check propApprove' onClick='callController(\".content\", \"proposalController\", \"$approveDataArg\");'></i>
			</div>
			<p>Proposed subject: <b>" . $secondaryProposals[$i]["proposalTitle"] . "</b></p>
			<p>Proposed by user <b>" . $secondaryProposals[$i]["proposalCreator"] . "</b> on " . $proposalDate . "</p>
			<p>Reason: " . $secondaryProposals[$i]["proposalReason"] . "</p>
			</div></td></tr>
			";
		}

		$view .= "</table></div>";
		return $view;
	}

}
?>