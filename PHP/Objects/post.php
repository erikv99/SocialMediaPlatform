<?php  
require_once("../generalFunctions.php");

Class Post 
{
	// NOTE: i decided not to make a getter/setter for each data point in the $postDBData since they wont be changed just used for getting other data like timeAgoCreated. Only content and title may change and these have dedicated update functions to do this.

	private static array $dbData;

	public function __construct(array $postDBData = []) 
	{
		$this::$dbData = $postDBData;
	}

	/**
	 * Function figures out how long ago the post was created in relation to the current time.
	 * 
	 * @return string $timeAgoCreated
	 */
	public function getTimeAgoCreated() 
	{
		// Checking if data is set or not.
		if(!$this->isDataSet()) 
		{
			// No need for error since that is handled inside the isdataset function
			return "Error";
		}

		$data = $this::$dbData;
		$postCreationDT = new DateTime($data["postCreationDatetime"]);
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
		// Checking if data is set or not.
		if(!$this->isDataSet()) 
		{
			// No need for error since that is handled inside the isdataset function
			return "Error";
		}
		$data = $this::$dbData;
		logDebug("blabla data : " . var_export($data,true));

		$postPreviewView = 
		"
		<table class='previewPostsTable'>
		<tr>
		<td><p class='postPreviewTitle'><a onclick='callController(\".content\", \"postPageController\", \"" . $data["PrimarySubject"] . "," . $data["SecondarySubject"] . "," . $data["postID"] . "\");'>" . $data["postTitle"] . "</a></p></td>
		</tr>
		<tr><td><p class='postPreviewAuthor'><i class='fas fa-book-reader'></i>  Posted by user <b>". $data["postCreator"] . "</b> " . $this->getTimeAgoCreated($data["postCreationDatetime"]) . "</p></td></tr>
		</table>
		";

		return $postPreviewView; 
	}

	/**
	 * Function updates the content of this post inside the database
	 * 
	 * @param $string updatedContent
	 */
	public function updateContent(string $updatedContent) 
	{
		// Checking if data is set or not.
		if(!$this->isDataSet()) 
		{
			// No need for error since that is handled inside the isdataset function
			return;
		}

		$postID = $this::$dbData["postID"]; 
		$dbConn = openDBConnection();

		try
		{
			$stmt = $dbConn->prepare("UPDATE posts SET postContent = ? WHERE postID = ?");
			$stmt->execute([$updatedContent, $postID]);
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		closeDBConnection($dbConn);
	}

	/**
	 * Function deletes the current post from the database.
	 */
	public function delete() 
	{
		// Checking if data is set or not.
		if(!$this->isDataSet()) 
		{
			// No need for error since that is handled inside the isdataset function
			return;
		}
		
		$postID = $this::$dbData["postID"]; 
		$dbConn = openDBConnection();

		try
		{
			$stmt = $dbConn->prepare("DELETE FROM posts WHERE postID = ?");
			$stmt->execute([$postID]);
		}
		catch (PDOException $e) 
		{
			throw new DBException($e->getMessage());
		}

		closeDBConnection($dbConn);
	}

	/**
	 * Function returns the dbData
	 *	
	 * @return array $dbData;
	 */
	public function getData() 
	{
		return $this::$dbData;
	}

	/**
	 * Checks if the data is set or not. if not it will throw a exception
	 * 
	 * @param bool $isDataSet
	 */
	private function isDataSet() 
	{
		if (!isset($this::$dbData["postTitle"])) 
		{
			try 
			{
				throw new CustomException("dbData not properely set");
			} 
			catch(CustomException $e) 
			{ 
				die("Check error.txt, or inform administrator"); 
			}

			return false;
		}

		return true;
	}
}
?>