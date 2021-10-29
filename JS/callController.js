function callController(placeMentTag, controllerName) 
{
	this.sendAjaxRequest(placeMentTag, controllerName, "")
}

function callControllerFromForm(placeMentTag, controllerName, formID) 
{
	var formData = $("." + formID).serialize();
	this.sendAjaxRequest(placeMentTag, controllerName, formData);
}

function sendAjaxRequest(placeMentTag, controllerName, data) 
{
	var filePath = "../PHP/Controllers/" + controllerName + ".php";
	
	$.ajax(
	{
		url: filePath, 
		method: "POST", 
		data: data,
	success: function(response) 
	{
		console.log(response);
		var jsonObj = JSON.parse(response);

		if (jsonObj.indexViewRequired == true) 
		{
			alert("is true");
			//window.location = "../index.php";

			window.addEventListener('load', function () {
		  		alert("It's loaded!");
			});
		}


		$(placeMentTag).append(jsonObj.view);	
	},
	error: function(xhr, status, error) 
	{
		console.log("prblem");
		var errorMessage = xhr.status + ': ' + xhr.statusText
		console.log('Error - ' + errorMessage)
	}
	})
}