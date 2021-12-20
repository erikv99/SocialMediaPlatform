<?php  
require_once("../Views/view.php");


/**
 * View class for the locationbars, does not extend view since it doesn't use its functions.
 */
class LocationBarView 
{	
	// EX: Home > Fruits > Apple > Post: How apples are made 
	// Home > Primary Subject > Secondary subject
	// Home > User: Erik

	static private array $locations = [];

	static private string $locationBarView = "";

	/**
	 * Creates the view for the locationBar
	 * 
	 * Example of a key value pair for the parameter: 
	 * (example: "Banana" => "callController('.content', 'primarySubjectController', 'Banana')")
	 * 
	 * @param array containing location names and js call to controller.
	 */
	public function setLocations(array $locations) 
	{
		$this::$locations = array_merge($this::$locations, $locations);
	}

	/**
	 * Creates the view and returns it
	 *
	 * Note: setLocations is not required to be used before using the createView but is needed if you want any custom locations in the navigation bar. 
	 * 
	 * @return string $view
	 */
	public function createView(array $locations = []) : string 
	{
		// Checking if the view doesn't want a locationbar
		if (isset($locations["noLocationBar"])) 
		{
			return "";
		}

		// Adding the first basic parts of the location, this is included on everypage.
		$view = "<div class='locationBar'><ul><li><i class='fas fa-map-signs'></i></li><li><a onclick='callController(\".content\", \"homeController\");'>Home</a></li>";
		$view .= "<li><i class='fas fa-chevron-right'></i></li><li><a onclick='callController(\".content\", \"contentController\");'>Subjects</a></li>";
		
		// Looping thru the locations using the key/value
		foreach ($locations as $key => $value)
		{
			$locationName = $key;

			// Splitting the value (callController(placementTag, controllername, args) on each comma so we can get the value at index 2 which is the args.)
			// We limited the result to 3, so if a comma is present in the arguments for example it wont affect this method.
			$splitResult = explode(",", $value, 3);

			if (isset($splitResult[2])) 
			{
				// Escaping the args value
				$splitResult[2] = htmlspecialchars($splitResult[2], ENT_QUOTES | ENT_HTML5, 'UTF-8');
	
				// Putting everything back in 1 array, this time the args being escaped.
				$value = implode(",", $splitResult);
			}

			$view .= "<li><i class='fas fa-chevron-right'></i></li><li><a onclick=\"" . $value . "\"> " . $locationName . "</a></li>";
		}

		$view .= "</ul></div>";
		return $view;
	}

	/**
	 * Function for getting the view
	 * 
	 * @return string $view
	 */
	public function getView() : string 
	{
		// Checking if locations array is empty 
		if (empty($this::$locations)) 
		{
			$this::$locationBarView = $this->createView();
		} 
		else 
		{
			$this::$locationBarView = $this->createView($this::$locations);
		}

		return $this::$locationBarView;
	}

}
?>