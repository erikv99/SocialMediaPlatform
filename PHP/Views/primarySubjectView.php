<?php  
require_once("view.php");
require_once("../Objects/post.php");

class PrimarySubjectView extends View 
{
	/**
	* Creates the view and returns it
	* 
	* @param array $modelView
	* @return string $view
	*/
	protected function createView($modelOutput) : string
	{
		$secondarySubjects = $modelOutput["secondarySubjects"];
		$previewPosts = $modelOutput["previewPosts"];
		$primarySubject = $modelOutput["primarySubject"];
		
		$view = 
		"
		<div class='subjectContainer primarySubjectPageTitle'>
			<table>
				<tr class=''><td class=''><p><i class='fas fa-marker'></i> " . $primarySubject . "</p></td></tr>
			</table>
		</div>
		";

		// Looping through the secondary subjects
		for ($i = 0; $i < count($secondarySubjects); $i++) 
		{
			// Getting the preview posts for the current secondary subject
			$previewPostsView = $this->getPreviewPostsView($previewPosts, $secondarySubjects[$i]);

			// Creating the view for the current secondary subject
			$view .=
			"
			<div class='subjectContainer previewPost" . $secondarySubjects[$i] . "'>
				<table>
					<tr class='subjectContainerHeaderRow'><td><p class='subjectContainerHeaderTitle'><i class='fab fa-hive'></i>
					<a onclick='callController(\".content\", \"secondarySubjectController\", \"" . $primarySubject . "," . $secondarySubjects[$i] . "\")'> " . $secondarySubjects[$i] . "</a></p>
					<div class='SCHeaderRowDoubleButton'>
						<button class='imageButton SCHeaderRowButton' onClick='callController(\".content\", \"createPostController\", \"" . $primarySubject . "," . $secondarySubjects[$i] . "\")'>
							<img class='SCHeaderRowButtonImg' src='../IMG/add.png'>
						</button>
						<button class='imageButton SCHeaderRowButton' onClick='collapseSubject(\".previewPost" . $secondarySubjects[$i] . "\");'>
							<img class='SCHeaderRowButtonImg' src='../IMG/collapse.png'>
						</button>
					</div>
					</td></tr>
					" . $previewPostsView . "
				</table>
			</div>
			";
		}

		return $view;
	}

	public function getView() : string 
	{
		$this::$viewContent = $this->createView($this::$output);
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
			$previewPostsView = "<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='postTitle noPostAvailable'>No posts available!</p></td></tr>";
	 	}
		else 
		{
			// Looping thru all the posts for the current secondarysubject
			for ($i = 0; $i < count($posts); $i++) 
			{
				// Making a post obj using the data.
				$post = new Post($posts[$i]);

				// Making the view 
				$previewPostsView .= 
				"
				<tr class='subjectContainerSubRow postPreview" . $secondarySubject ."' ><td class='subjectContainerSubRowTD postPreviewTD'>
				" .  $post->getPreviewView() . "
				";
			}
		}	
				
		return $previewPostsView;
	}
}
?>