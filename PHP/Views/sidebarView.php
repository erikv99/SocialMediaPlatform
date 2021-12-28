<?php  
require_once('view.php');

/**
 * View class for the sidebar page 
 */
class SidebarView extends View 
{
	/**
	 * Function which makes/creates the actual view. (the specific to this page part)
	 * 
	 * @param array $modelOutput
	 * @return string $view
	 */
	public function createView(array $modelOutput) : string
	{
		$view = "
		<div class='sidebar'>
			<div class='collapsedSidebar'>
				<button class='imageButton sbExpandArrow'>
				<img class='sidebarArrowImg' style='transform: rotate(180deg);' onClick='expandSidebar()' src='../IMG/back.png'></img>
				</button>		
			</div>
			<div class='expandedSidebar'>
				<button class='imageButton sbCollapseArrow'>
					<img class='sidebarArrowImg' onClick='collapseSidebar()' src='../IMG/back.png'></img>
				</button>
				<div class='sidebarContent'>
						<p class='button'><a onClick='callController(\".content\", \"homeController\");'>Home</a></p>	
						<p class='button'><a onClick='callController(\".content\", \"contentController\");'>Subjects</a></p>	
						<p class='button userButton'><a onclick='callController(\".content\", \"proposalController\")'>Proposals</a></p>
						<p class='button'><a onclick='callController(\".content\", \"infoController\")'>Info</a></p>
						<p class='button'><a onClick='callController(\".content\", \"contactController\");'>Contact</a></p>
						<p class='button'><a onClick='callController(\".content\", \"aboutUsController\");'>About us</a></p>
						<p class='button adminButton'><a onClick='callController(\".content\", \"adminController\");'>Admin</a></p>		
				</div>
				<p class='sidebarFooter'><i class='far fa-copyright'></i> Erik V.</p>
			</div>     
		</div>
		";

		return $view;
	}

	/**
	 * Gets the view and returns it
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