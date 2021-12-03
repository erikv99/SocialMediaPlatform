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

// Function refreshes the current page, gets the last called controller from the cookies then calls this controller using the callController function
function refreshPage() 
{	
	console.log("refreshPage called");

	// Getting the data for the controller to call from the cookie
	var controllerName = this.getCookie("lastControllerName");
	var placementTag = this.getCookie("lastControllerPlacementTag");
	var dataAsJson = this.getCookie("lastControllerData");
	console.log("dataAsJson: " + dataAsJson);
	// Transforming the json to a obj.
	var dataObj = JSON.parse(dataAsJson);
	console.log("dataobj: " + dataObj);
	// getting the data itself
	var data = dataObj["data"];
	console.log("data: " + data);

	// Calling that controller
	callController(placementTag, controllerName, data);
}

// Definitely not copied this from https://www.w3schools.com/js/js_cookies.asp
function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}