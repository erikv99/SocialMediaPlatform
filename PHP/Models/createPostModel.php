<?php  
require_once("model.php");

class CreatePostModel extends Model 
{
	public function execute() : array 
	{
		$returnData = [];

		// Checking if the post var is empty or not. 
		if ($this->isPostDataEmpty())
		{
			return $returnData;
		}

		// Checking if user is logged in, else returning with a alert informing the user
		if (!isUserLoggedIn()) 
		{
			echo json_encode(["view" => "<script type='text/javascript'>callController(\".page\", \"alertController\", {\"alertType\":\"alertInfo\",\"alertMessage\":\"Must be logged in to create a new post\"});</script>"]);
			die();
		}

		// Getting the primary and secondary subjects from the data given
		$temp = explode(",", $_POST['data']);
		$primarySubject = $temp[0];
		$secondarySubject = $temp[1];

		// Setting the subjects since they are needed in the view when calling this function again for saving. basically this would be some form of recursion i guess.
		$returnData["primarySubject"] = $primarySubject;
		$returnData["secondarySubject"] = $secondarySubject;

		// checking if the $temp[2] exists, then checking if the arg is create.
		if (isset($temp[2])) 
		{
			// Just a little bit of extra verification, not really needed but whatever.
			if ($temp[2] == "create") 
			{
				$this->createNewPost($temp);
				logDebug("create, temp: " . var_export($temp,true));

			}
		}
		// Setting the locations for the locationsbar
		$returnData["locations"] = 
		[
			$primarySubject => "callController('.content', 'primarySubjectController', '$primarySubject')",
			$secondarySubject => "callController('.content', 'secondarySubjectController', '$primarySubject,$secondarySubject')",
			"Create post" => "callController('.content', 'createPostController', '$primarySubject,$secondarySubject')"
		];
	
		return $returnData;
	}

	private function createNewPost(array $temp)  
	{
		session_start();

		//$postCreatorID = 
	}	
}
?>