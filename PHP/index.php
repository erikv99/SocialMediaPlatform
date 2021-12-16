<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../CSS/stylesheet.css"/>
	<link rel="stylesheet" type="text/css" href="../CSS/loginStyleSheet.css"/>
	<link rel="stylesheet" type="text/css" href="../CSS/content.css"/>
	<link rel="stylesheet" type="text/css" href="../CSS/headerStyleSheet.css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/969d13854d.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="../JS/globalFunctions.js"></script>
	<script type="text/javascript" src="../JS/buttonHandler.js"></script>
	<script type="text/javascript" src="../JS/onDocumentReady.js"></script>
	<script type="text/javascript" src="../JS/callController.js"></script>
	<title>Thoughtshare</title>
</head>
<body>
<div class="header"></div>
<div class="page">
	<div class="content">
		<script type = "text/javascript">  
			callController(".content", "contentController");
			callController(".header", "headerController");
         </script> 
	</div>
<?php 	
	include_once("Include/sidebar.inc.php");
?>

</div>
</body>
</html>

