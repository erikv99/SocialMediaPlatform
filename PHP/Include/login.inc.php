<div class="loginContainer">
	<div class="loginFormContainer">
		<button class="cancelButton" onClick="hideLogin()">
			<img src="../IMG/cancel.png" class="cancelImage"></img>
		</button>
		<form action="Controllers/registerController.php" method="POST">
			<label for="text">Username: </label>
			<input type="text" name="username" minlength="2" maxlength="30" required>
			<label for="password">Password: </label>
			<input type="password" name="password" minlength="2" maxlength="30" required>
			<label class="confirmPassword" for="confirmPassword">Confirm password</label>
			<input class="confirmPassword" type="password" name="confirmPassword" minlength="2" maxlength="30" required/>
			<br/>
			<input class="submitButton" type="submit" value="Log in">
			<div class="loginErrorBox">
				<p>Error: Passwords are not identical</p>
			</div>
		</form>
	</div>
</div>
