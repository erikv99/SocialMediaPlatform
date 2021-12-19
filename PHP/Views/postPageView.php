<?php  
require_once("view.php");
require_once("../Objects/post.php");

/**
 * View class for the postPage
 */
class PostPageView extends View 
{
	/**
	 * Function which makes/creates the actual view. (the specific to this page part)
	 * 
	 * @param array $modelOutput
	 * @return string $view
	 */
	protected function createView(array $modelOutput) : string 
	{		
		$post = new Post($modelOutput["postData"]);
		$data = $post->getData();
		$viewType = $modelOutput["viewType"];
		$view = "";
		
		// Getting the right type of view depending on the viewtype. 
		switch($viewType) 
		{
			case "normal":
				$view = $this->createNormalView($data, $post);
				break;
			case "owner":
				$view = $this->createOwnerView($data, $post);
				break;
			case "edit":
				$view = $this->createEditView($data, $post);
				break;

		}
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

	/** 
	 * Creates the view when the viewtype is "normal"
	 * 
	 * @param array $data
	 * @param Post $post
	 * @return string $view
	 */
	private function createNormalView(array $data, Post $post) : string
	{
		$view = "
		<div class='postContainer'>
		<table>
			<tr class='postContainerHeaderRow'><td><p class='postTitle'>" . $data["postTitle"] . "</p></tr></td>
			<tr class='postContainerContentRow'><td><p class='postContent'>" . $data["postContent"] .  "</p></td></tr>
			<tr class='postContainerContentRow'><td><p class='postAuthor'><i class='fas fa-book-reader'></i>  Posted by user <b><a onClick='callController(\".content\", \"accountPageController\", \"" . $data["postCreator"] . "\");'>". $data["postCreator"] . "</a></b> " . $post->getTimeAgoCreated($data["postCreationDatetime"]) . "</p></td></tr>
		</table>
		</div>
		";
		return $view;
	}

	/** 
	 * Creates the view when the viewtype is "owner"
	 * 
	 * @param array $data
	 * @param Post $post
	 * @return string $view
	 */
	private function createOwnerView(array $data, Post $post) : string 
	{
		$escapedPrimSub = htmlspecialchars($data["PrimarySubject"], ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$escapedSecSub = htmlspecialchars($data["SecondarySubject"], ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$editButtonDataArgument = $escapedPrimSub . "|" . $escapedSecSub . "|" . $data["postID"] . "|edit";
		$deleteButtonDataArgument =  $escapedPrimSub . "|" . $escapedSecSub . "|" . $data["postID"] . "|delete";
		$view = "
		<div class='postContainer'>
		<table>
			<tr class='postContainerHeaderRow'>
			<td><p class='postTitle'>" . $data["postTitle"] . "</p>
			<div class='postActionButtons'>
				<a onclick='callController(\".content\", \"postPageController\", \"$editButtonDataArgument\");'><i class='fas fa-edit'></i></a>
				<a onclick='callController(\".content\", \"postPageController\", \"$deleteButtonDataArgument\");'><i class='far fa-trash-alt'></i></a>
			</div></tr></td>
			<tr class='postContainerContentRow'><td><p class='postContent'>" . $data["postContent"] .  "</p></td></tr>
			<tr class='postContainerContentRow'><td><p class='postAuthor'><i class='fas fa-book-reader'></i>  Posted by user <a onClick='callController(\".content\", \"accountPageController\", \"" . $data["postCreator"] . "\");'><b>". $data["postCreator"] . "</a></b> " . $post->getTimeAgoCreated($data["postCreationDatetime"]) . "</p></td></tr>
		</table>
		</div>
		";
		return $view;
	}

	/** 
	 * Creates the view when the viewtype is "edit"
	 * 
	 * @param array $data
	 * @param Post $post
	 * @return string $view
	 */
	private function createEditView(array $data, Post $post) : string
	{
		$escapedPrimSub = htmlspecialchars($data["PrimarySubject"], ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$escapedSecSub = htmlspecialchars($data["SecondarySubject"], ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$editButtonDataArgument = $escapedPrimSub . "|" . $escapedSecSub . "|" . $data["postID"] . "|delete";
		$saveButtonDataArgument =  $escapedPrimSub . "|" .$escapedSecSub . "|" . $data["postID"] . "|save|\" + document.getElementById(\"editedContent\").value";
		$view = "
		<div class='postContainer'>
		<table>
			<tr class='postContainerHeaderRow'>
			<td><p class='postTitle'>" . $data["postTitle"] . "</p>
			<div class='postActionButtons'>
				<a onclick='callController(\".content\", \"postPageController\", \"$editButtonDataArgument\");'><i class='far fa-trash-alt'></i></a>
				<a onclick='callController(\".content\", \"postPageController\", \"$saveButtonDataArgument);'><i class='fas fa-check'></i></a>
			</div></tr></td>
			<tr class='postContainerContentRow'><td><p class='postContent'><textarea id='editedContent'>" . $data["postContent"] .  "</textarea></p></td></tr>
			<tr class='postContainerContentRow'><td><p class='postAuthor'><i class='fas fa-book-reader'></i>  Posted by user <a onClick='callController(\".content\", \"accountPageController\", \"" . $data["postCreator"] . "\");'><b>". $data["postCreator"] . "</a></b> " . $post->getTimeAgoCreated($data["postCreationDatetime"]) . "</p></td></tr>
		</table>
		</div>
		";
		return $view;
		//
	}
}
?>