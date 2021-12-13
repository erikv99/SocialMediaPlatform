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

		$dataArg = $modelOutput["primarySubject"] . "|" . $modelOutput["secondarySubject"];
		$dataArg = htmlspecialchars($dataArg, ENT_QUOTES | ENT_HTML5, 'UTF-8');
		// Getting the first part of the view, basically the secondary subject title
		$view = "
		<div class='subjectContainer'>
		<table>
			<tr class='subjectContainerHeaderRow'>
			<td><p class='subjectContainerHeaderTitle'><i class='fab fa-hive'></i> " . $modelOutput["secondarySubject"] . "</p>
			<div class='SCHeaderRowSingleButton'>
				<button class='imageButton SCHeaderRowButton' onClick='callController(\".content\", \"createPostController\", \"$dataArg\")'>
					<img class='SCHeaderRowButtonImg' src='../IMG/add.png'>
				</button>
			</div></td>
			</tr>";

		// Checking if any posts available are empty or not
		if (empty($previewPosts)) 
		{
			// Getting the view for no posts
			$postPreviewView = "<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'><p class='subjectContainerSubTitle'>No posts available!</p></td></tr>";
			$view .= $postPreviewView;
		}
		else
		{
			// Looping through the previewPosts
			for ($i = 0; $i  < count($previewPosts); $i++) 
			{
				// Making a post obj for the current post
				$post = new Post($previewPosts[$i]);
				
				// Getting the previewView
				$postPreviewView = "<tr class='subjectContainerSubRow'><td class='subjectContainerSubRowTD'>" . $post->getPreviewView() . "</td></tr>";
				
				// Adding the view to the total view.
				$view .= $postPreviewView;
			}
		}

		// Adding the last line of the view then returning it
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