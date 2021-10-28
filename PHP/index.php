<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../CSS/stylesheet.css"/>
	<link rel="stylesheet" type="text/css" href="../CSS/loginStyleSheet.css"/>
	<link rel="stylesheet" type="text/css" href="../CSS/content.css"/>
	<title>Thoughtshare</title>
</head>
<body>
<div class="page">
	<div class="content">
		<?php 
			include("subjectContainer.php");

		?> 
	</div>
		<?php 	
	include_once("Include/header.inc.php");
	include_once("Include/sidebar.inc.php");

	?>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="../JS/buttonHandler.js"></script>
</body>
</html>

