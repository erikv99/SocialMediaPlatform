<?php  
require_once("view.php");
require_once("../Objects/post.php");

class PostPageView extends View 
{
	protected function createView(array $modelOutput) : string 
	{		
		$post = new Post($modelOutput["postData"]);
		$data = $post->getData();
		logDebug("data: " . var_export($modelOutput["viewType"],true));
		
		$view = "
		<div class='postContainer'>
		<table>
			<tr class='postContainerHeaderRow'>
			<td><p class='postTitle'>" . $data["postTitle"] . "</p>
			<div class='postActionButtons'>
				<a onclick='callController(\".content\", \"postPageController\", \"" . $data["PrimarySubject"] . "," . $data["SecondarySubject"] . "," . $data["postID"] . ",edit\")'><i class='fas fa-edit'></i></a>
				<a onclick='callController(\".content\", \"postPageController\", \"" . $data["PrimarySubject"] . "," . $data["SecondarySubject"] . "," . $data["postID"] . ",delete\")'><i class='far fa-trash-alt'></i></a>
			</div></tr></td>
			<tr class='postContainerContentRow'><td><p class='postContent'>" . $data["postContent"] .  "</p></td></tr>
			<tr class='postContainerContentRow'><td><p class='postAuthor'><i class='fas fa-book-reader'></i>  Posted by user <b>". $data["userName"] . "</b> " . $post->getTimeAgoCreated($data["postCreationDatetime"]) . "</p></td></tr>
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
}
?>