<?php  
require_once("../generalFunctions.php");

Class Post 
{
	// NOTE: i decided not to make a getter/setter for each data point in the $postDBData since they wont be changed just used for getting other data like timeAgoCreated. Only content and title may change and these have dedicated update functions to do this.

	private array $dbData = [];

	public function __construct(array $postDBData = []) 
	{
		$this->dbData = $postDBData;
	}

	/**
	 * Function figures out how long ago the post was created in relation to the current time.
	 * 
	 * @return string $timeAgoCreated
	 */
	private function getTimeAgoCreated() 
	{
		// Checking if the $dbData has a $postcreationDateTime property.
		if (!isset($this->dbData["postCreationDatetime"]))
		{
			try 
			{
				throw new CustomException("postCreationDatetime not set in dbData, is dbData updated/set?");
			} 
			catch(CustomException $e) { die("Check error.txt, or inform administrator"); }
		} 

		if (empty($this->dbData["postCreationDatetime"])) 
		{
			try
			{
				throw new CustomException("postCreationDatetime is empty.");
			} catch (CustomException $e) { return "notSet"; }
		}
	
	
		$postCreationDT = new DateTime($this->dbData["postCreationDatetime"]);
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

	/**
	 * Returns the view for the current post its preview
	 * 
	 * @return $string previewView
	 */
	public function getPreviewView() 
	{
		$data = $this->dbData;

		$postPreviewView = 
		"
		<table class='previewPostsTable'>
		<tr>
		<td><p class='postPreviewTitle'>" . $data["postTitle"] . "</p></td>
		</tr>
		<tr><td><p class='postPreviewAuthor'><i class='fas fa-book-reader'></i>  Posted by user <b>". $data["userName"] . "</b> " . $this->getTimeAgoCreated($data["postCreationDatetime"]) . "</p></td></tr>
		</table>
		";

		return $postPreviewView; 
	}

	/**
	 * Function updates the content of this post inside the database
	 * 
	 * @param $string updatedContent
	 */
	public function updateContent($updatedContent) 
	{

	}

	/**
	 * Function updates the title of this post inside the database
	 * 
	 * @param $string updatedTitle
	 */
	public function updateTitle($updatedTitle) 
	{

	}

	/**
	 * Function deletes the current post from the database.
	 */
	public function delete() 
	{

	}

	/**
	 * Function returns the dbData
	 *	
	 * @return array $dbData;
	 */
	public function getData() 
	{
		return $this->dbData;
	}
}
?>