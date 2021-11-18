<?php  
require_once("../Views/view.php");

class PrimarySubjectView extends View 
{
	protected function createView() 
	{
		$output = $this->getOutput();
		$secondarySubjects = $output["secondarySubjects"];
		$previewPosts = $output["previewPosts"];

		$this::$viewContent = 
		"
		<div class='subjectContainer primarySubjectPageTitle'>
			<table>
				<tr><td class=''><p><i class='fas fa-marker'></i> " . $output["primarySubject"] . "</p></td></tr>
			</table>
		</div>
		";

		// Looping through the secondary subjects
		for ($i = 0; $i < count($secondarySubjects); $i++) 
		{
			// Getting the preview posts for the current secondary subject
			$previewPostsView = $this->getPreviewPostsView($previewPosts, $secondarySubjects[$i]);

			// Creating the view for the current secondary subject
			$this::$viewContent .= 
			"
			<div class='subjectContainer previewPost" . $secondarySubjects[$i] . "'>
				<table class='previewPostsOutline'>
					<tr ><td class='primarySubjectTitle'><p><i class='fab fa-hive'></i> " . $secondarySubjects[$i] . "</p>
							<button class='imageButton collapseSubjectButton' onClick='collapseSubject(\".previewPost" . $secondarySubjects[$i] . "\");'>
							<img class='collapseSubjectImg' src='../IMG/collapse.png'>
						</button>
					</td></tr>
					" . $previewPostsView . "
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

	private function getPreviewPostsView($previewPosts, $secondarySubject) : string 
	{
		$previewPostsView = "";

		// Checking if the current secondary subject exists inside the previewPosts
		if (!array_key_exists($secondarySubject, $previewPosts)) 
		{
			return "";
		}
			
		// Getting the array containing all posts to preview for the current secondarySubject
		$posts = $previewPosts[$secondarySubject];

		// Checking if the current secondary subject has any posts (checking if array is not empty)
		if (empty($posts)) 
		{
			// If its empty we want to add a "no posts created yet" type box
			$previewPostsView = "<tr class='secondarySubjectRow'><td class='secondarySubjectTitle'><p>No posts available!</p></td></tr>";
	 	}
		else 
		{
			// Looping thru all the posts for the current secondarysubject
			for ($i = 0; $i < count($posts); $i++) 
			{
				$post = $posts[$i];
				$previewPostsView .= 
				"
				<tr class='secondarySubjectRow postPreview" . $secondarySubject ."'><td class='secondarySubjectTitle'>
				<table class='previewPostsTable'>
				<tr><td><p>" . $post["postTitle"] . "</p></td></tr>
				<tr><td><p id='previewPostAuthor'><i class='fas fa-book-reader'></i>  Posted by " . $post["postCreatorID"] . "</p></td></tr>

				</table>
				";
			}

		}	
		
		return $previewPostsView;
	}

}
?>