<?php  
require_once("view.php");
require_once("../Objects/post.php");

class SecondarySubjectView extends View 
{
	/**
	 * Creates the view and returns it
	 * 
	 * @param array $modelView
	 * @return string $view
	 */
	protected function createView(array $modelOutput) : string
	{
		// Getting the previewPosts which are set up by our model.
		$previewPosts = $modelOutput["previewPosts"];

		//$view = "<div class='subjectContainer'><table class='previewPostOutline'><tr><td><p><i class='fas fa-marker'></i> " . $modelOutput["secondarySubject"] . "</p></td></tr></table>";

		$view = "
		<div class='subjectContainer'>
		<table class='previewPostsOutline'>
		<tr><td class='primarySubjectTitle'><p><i class='fab fa-hive'></i> " . $modelOutput["secondarySubject"] . "</p></td></tr>";

		// Looping through the previewPosts
		for ($i = 0; $i  < count($previewPosts); $i++) 
		{
			// Making a post obj for the current post
			$post = new Post($previewPosts[$i]);
			
			// Getting the previewView
			$postPreviewView = $post->getPreviewView();

			// Adding the view to the total view.
			$view .= $postPreviewView;
		}

		$view .= "</table></div>";
		return $view;
	}

	/**
	 * Returns the view for this MVC
	 * 
	 * @return string $view
	 */
	public function getView() : string 
	{
		$this::$viewContent = $this->createView($this::$output);
		return Parent::getViewContent();
	}
}
?>