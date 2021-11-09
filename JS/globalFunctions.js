// Contains functions needed throughout the site

// Takes the actions needed when a user is logged in
function userIsLoggedIn() 
{
	$("#loginButtons").hide();
	$("#logoutButtons").show();
}

// Takes the actions needed when a user is not logged in
function userIsNotLoggedIn()
{
	$("#logoutButtons").hide();
	$("#loginButtons").show();
}

// Will check if the user is logged in and take the appropiate actions.
function loginCheck() 
{
	// Sending a request to php to see if the user is logged in or not 
	$.ajax(
	{
		url: "../PHP/Ajax/loginCheck.ajax.php",
		method: "GET",

		success: function(response) 
		{
			console.log(response);
			// Parsing the json response into a object
			var obj = JSON.parse(response);

			// calling the correct function depending if the user is logged in or not
			if (obj.loginButtonsAction == "show") 
			{
				userIsNotLoggedIn();
			} 
			else if(obj.loginButtonsAction == "hide") 
			{
				userIsLoggedIn();
			}
		},
		error: function(xhr, status, error) 
		{
			var errorMessage = xhr.status + ': ' + xhr.statusText;
			console.log(errorMessage);
		}
	});
}

// function will rotate a img by x degrees, requires a jquery img handle
function rotateImage(imgHandle, degrees) 
{
	imgHandle.css({
		"transform" : "rotate(" + degrees + "deg)",
		"-moz-transform" : "rotate(" + degrees + "deg)",
		"-ms-transform" : "rotate(" + degrees + "deg)",
		"-webkit-transform" : "rotate(" + degrees + "deg)",
		"-o-transform" : "rotate(" + degrees + "deg)"
	});
}