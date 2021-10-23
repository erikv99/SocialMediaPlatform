<?php 
	class View 
	{
		private string $view;

		function __construct() 
		{
			$this->view = 			
			"
			<html>
			<head>
				<title>Thoughtshare</title>
			</head>
			<body>
			<div class='overlay'/>	
			<div class='page'>
				<div class='content'>
				</div>
				<?php 	
				include_once('Include/header.inc.php');
				include_once('Include/sidebar.inc.php');
				?>
			</div>
			<link rel='stylesheet' type='text/css' href='../CSS/stylesheet.css'/>
			<link rel='stylesheet' type='text/css' href='../CSS/loginStyleSheet.css'/>
			<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
			<script type='text/javascript' src='../JS/loginButtonHandler.js'></script>
			<script type='text/javascript' src='../JS/SidebarFunctions.js'></script>
			</body>
			</html>
			";

		}

		function setContent($content) 
		{
			$this->view = 			
			"
			<!DOCTYPE html>
			<html>
			<head>
				<title>Thoughtshare</title>
			</head>
			<body>
			<div class='overlay'/>	
			<div class='page'>
				<div class='content'>
				" . $content ."
				</div>
				\<?php 	
				include_once('Include/header.inc.php');
				include_once('Include/sidebar.inc.php');
				?\>
			</div>
			<link rel='stylesheet' type='text/css' href='../CSS/stylesheet.css'/>
			<link rel='stylesheet' type='text/css' href='../CSS/loginStyleSheet.css'/>
			<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
			<script type='text/javascript' src='../JS/loginButtonHandler.js'></script>
			<script type='text/javascript' src='../JS/SidebarFunctions.js'></script>
			</body>
			</html>
			";
		}

		function getView()
		{
			return $this->view;
		}
	}
?>