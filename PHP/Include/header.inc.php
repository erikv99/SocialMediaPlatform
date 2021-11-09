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
				<button type="button" class="button" id="signupButton" onClick="callController('body', 'registerController');"><i class="fas fa-user-plus"></i> Sign up</button>
				<button type="button" class="button" id="loginButton" onClick="callController('body', 'loginController');"><i class="fas fa-user-check"></i> Log in</button>
			</td>
			<td id="logoutButtons">
				<button type="button" class="button" id="accountButton" onClick=""><i class="fas fa-user-cog"></i> Account</button>
				<button type="button" class="button" id="logoutButton" onClick="logout();"><i class="fas fa-user-times"></i> Log out</button>
			</td>
		</tr>
	</table>	
</div>