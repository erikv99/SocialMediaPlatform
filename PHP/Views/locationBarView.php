<?php  
require_once("../Views/view.php");

class LocationBarView extends View 
{	
	// EX: Home > Fruits > Apple > Post: How apples are made 
	// Home > Primary Subject > Secondary subject
	// Home > User: Erik
	// NOT SHOWING THIS ON THE HOME PAGE SINCE WE CAN ONLY SHOW "Home there????????????????"

	// Each page calls this with either 1, 2 or 3 arguments. 
	static private array $locations = [];

	static private string $locationBarView = "";

	/**
	 * Creates the view for the locationBar
	 * 
	 * @param array containing location names as keys and controller to call name as values. (ex. "Home" => "contentController")
	 */
	protected function setLocations(array $locations) 
	{
		$this::$locations = array_merge($this::$locations, $locations);
	}

	// setLocations is not required to be used before using the createView but is needed if you want any custom locations in the navigation bar. 
	protected function createView() 
	{
		$locations = $this::$locations;
		$locationBarView = &$this::$locationBarView;
		$locationBarView .= "<div class='locationBar'><ul><li><i class='fas fa-map-signs'></i></li><li><a href='index.php'>ThoughtShare</a></li>";
		$locationBarView .= "<li><i class='fas fa-chevron-right'></i></li><li><a href='index.php'>Subjects</a></li>";
	
		foreach ($locations as $key => $value)
		{
			$locationName = $key;

			$locationBarView .= "<li><i class='fas fa-chevron-right'></i></li><li><a onclick=\"" . $value . "\"> " . $locationName . "</a></li>";
		}

		$locationBarView .= "</ul></div>";
	}

	public function getView() : string 
	{
		//$this->createView();
		return $this::$locationBarView;
	}

}
?>