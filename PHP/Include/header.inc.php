<script type="text/javascript" src="../JS/callController.js"></script>
<div class="header">
	<link rel="stylesheet" type="text/css" href="../CSS/headerStyleSheet.css"/>
	<table>
		<tr>
			<td>
				<img src="../IMG/headerIcon.png" class="headerIcon" alt="Thinking related image"/>	
			</td>
			<td>
				<h1>ThougtShare</h1>
			</td>
			<td id="loginButtons">
				<button type="button" id="loginButton" onClick="callController('body', 'loginController');">Log in</button>
				<button type="button" id="signupButton" onClick="callController('body', 'registerController');">Sign up</button>

			</td>
		</tr>
	</table>	
</div>