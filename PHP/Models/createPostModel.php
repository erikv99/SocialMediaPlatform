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


		//example of call: callController('.content', 'createPostController', 'Fruits,Apple')
		

		// Getting the primary and secondary subjects from the data given
		$temp = explode(",", $_POST['data']);
		$primarySubject = $temp[0];
		$secondarySubject = $temp[1];

		// Setting the locations for the locationsbar
		$returnData["locations"] = 
		[
			$primarySubject => "callController('.content', 'primarySubjectController', '$primarySubject')",
			$secondarySubject => "callController('.content', 'secondarySubjectController', '$primarySubject,$secondarySubject')",
			"Create post" => "callController('.content', 'createPostController', '$primarySubject,$secondarySubject')"
		];
	
		return $returnData;
	}	
}
?>