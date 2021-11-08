<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../CSS/stylesheet.css"/>
	<link rel="stylesheet" type="text/css" href="../CSS/loginStyleSheet.css"/>
	<link rel="stylesheet" type="text/css" href="../CSS/content.css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="../JS/globalFunctions.js"></script>
	<script type="text/javascript" src="../JS/buttonHandler.js"></script>
	<script type="text/javascript" src="../JS/onDocumentReady.js"></script>
	<script type="text/javascript" src="../JS/callController.js"></script>
	<title>Thoughtshare</title>
</head>
<body>
<div class="page">
	<div class="content">
		<script type = "text/javascript">  
			callController("body", "contentController");
         </script> 
		<?php 

			include("subjectContainer.php");

		?> 
	</div>
		<?php 	
	include_once("Include/header.inc.php");
	include_once("Include/sidebar.inc.php");

	?>

</div>
</body>
</html>

