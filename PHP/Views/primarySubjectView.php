<?php  
require_once("../Views/view.php");
require_once("../Objects/post.php");

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

	/**
	 * Function gets previewPostsview for the given secondary subject
	 * 
	 * @param string $secondarySubject
	 * @return string $previewPostsView
	 */
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
				<tr>
				<td><p>" . $post["postTitle"] . "</p></td>
				</tr>
				<tr><td><p id='previewPostAuthor'><i class='fas fa-book-reader'></i>  Posted by user <b>". $post["userName"] . "</b> " . $this->getTimeAgoCreatedView($post["postCreationDatetime"]) . "</p></td></tr>
				</table>
				";

				// Creating a new post object
				/*$post = new Post($posts[$i]);
				$postData = $post->getData();
				$previewPostsView .= 
				"
				<tr class='secondarySubjectRow postPreview" . $secondarySubject ."'><td class='secondarySubjectTitle'>
				<table class='previewPostsTable'>
				<tr>
				<td><p>" . $postData["postTitle"] . "</p></td>
				</tr>
				<tr><td><p id='previewPostAuthor'><i class='fas fa-book-reader'></i>  Posted by user <b>". $postData["userName"] . "</b> " . $post->getTimeAgoCreated() . "</p></td></tr>

				</table>
				";*/
			}

		}	
		
		return $previewPostsView;
	}

	/**
	 * Figures out how long ago the post was made and returns this.
	 * This function contains both model and view, for easy of use its placed in the view class in this case
	 * 
	 * @param $postCreationDatetime
	 * @return string $timeAgoCreatedView
	 */
	private function getTimeAgoCreatedView($postCreationDatetime) 
	{
		$postCreationDT = new DateTime($postCreationDatetime);
		$nowDT = new DateTime("NOW");
		$difference = $nowDT->diff($postCreationDT);
		$timeAgoCreated = "";
		
		// This function is really long and ugly but i really wanted to make it :)
		if ($difference->y != 0) 
		{
			$timeAgoCreated = $difference->y . " year(s)";
		} 
		elseif($difference->m != 0) 
		{
			$timeAgoCreated = $difference->m . " month(s)";
		}
		elseif($difference->d != 0) 
		{
			$timeAgoCreated = $difference->d . " day(s)";
		}
		elseif($difference->h != 0) 
		{
			$timeAgoCreated = $difference->h . " hour(s)";
		}	 
		elseif($difference->m != 0) 
		{
			$timeAgoCreated = $difference->m . " minute(s)";
		}
		else 
		{
			$timeAgoCreated = "less then a minute";
		}


		$view = "$timeAgoCreated ago";
		return $view;
	}
}
?>