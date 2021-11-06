$( document ).ready( function(){
	
	// Sending a request to php to see if the user is logged in or not 
	$.ajax(
	{
		url: "../PHP/Include/loginCheck.inc.php",
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
				userIsNotLoggedIn();
			}
		},
		error: function(xhr, status, error) 
		{
			var errorMessage = xhr.status + ': ' + xhr.statusText;
			console.log(errorMessage);
		}
	});

});

function userIsLoggedIn() 
{
	$("#loginButtons").hide();
}

function userIsNotLoggedIn()
{
	$("#loginButtons").show();
}