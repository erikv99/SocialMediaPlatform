<?php  
require_once('view.php');

/**
 * View class for the header 
 */
class HeaderView extends View 
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

		<table>		
			<tr>		
				<td>		
					<img src='../IMG/headerIcon.png' class='headerIcon' alt='Thinking related image'/>			
				</td>		
				<td>		
					<h1><a class='headerTitle' onclick='callController(\".content\", \"homeController\");'>ThougtShare</a></h1>		
				</td>
				<td id='logoutButtons'>
				<button type='button' class='button' id='accountButton' onClick='callController(\".content\", \"accountPageController\", \"currentUser\");'><i class='fas fa-user-cog'></i> Account</button>
				<button type='button' class='button' id='logoutButton' onClick='logout();'><i class='fas fa-user-times'></i> Log out</button>
				</td>
				<td id='loginButtons'>		
					<button type='button' class='button' id='signupButton' onClick='callController(\"body\", \"registerController\");'><i class='fas fa-user-plus'></i> Sign 		up</button>
					<button type='button' class='button' id='loginButton' onClick='callController(\"body\", \"loginController\");'><i class='fas fa-user-check'></i> Log in</button>
				</td>		
			</tr>
		</table>";

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