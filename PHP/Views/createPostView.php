<?php  
require_once("view.php");

/**
 * View class for the create post where users can make a new post
 */
class CreatePostView extends View 
{
	/**
	 * Function which makes/creates the actual view. (the specific to this page part)
	 * 
	 * @param array $modelOutput
	 * @return string $view
	 */
	protected function createView(array $modelOutput) : string
	{
		$escapedPrimSub = htmlspecialchars($modelOutput["primarySubject"], ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$escapedSecSub = htmlspecialchars($modelOutput["secondarySubject"], ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$callControllerDataArg = $escapedPrimSub . "|" . $escapedSecSub . "|create|\" + document.getElementById(\"createPostTitle\").value + \"|\" + document.getElementById(\"createPostContent\").value";
		$view = "
		<div class='postContainer'>
		<table>
			<tr class='postContainerHeaderRow'>
			<td><p class='postTitle'><input type='text' id='createPostTitle' placeholder='Enter post title'></input></p>
			<div class='postActionButtons'>
				<a onclick='callController(\".content\", \"createPostController\", \"$callControllerDataArg);'><i class='fas fa-check'></i></a>
			</div></tr></td>
			<tr class='postContainerContentRow'><td><p class='postContent'><textarea id='createPostContent' placeholder='Enter post content'></textarea></p></td></tr>
		</table>
		</div>";
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
