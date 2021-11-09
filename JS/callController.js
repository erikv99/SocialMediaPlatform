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
			console.log("Content before parse:\n" + response);
			// Parsing the json to a object
			var jsonObj = JSON.parse(response); 

			console.log("Content after parse:\n" + jsonObj.view);

			// Checking if the jsonObj contains a "objectsToRemove" key. (only returned if needed)
			if (jsonObj.hasOwnProperty("objectsToRemove")) 
			{
				// removing any elements from the view if needed.
				removeElementsFromView(jsonObj.objectsToRemove);
			}

			// Getting our view from our object and appending it (placing it before) the placementTag
			$(placeMentTag).append(jsonObj.view);	

			// If we did any action regarding the loginController we want to do a loginCheck()
			if (controllerName == "loginController") 
			{
				loginCheck();
			}
		},
		error: function(xhr, status, error) 
		{
			var errorMessage = xhr.status + ': ' + xhr.statusText;
			console.log(errorMessage);
		},
	});
}

// Function to remove multiple elements from the view, requires an array with the className of each object to be removed
function removeElementsFromView(objectsToRemove) 
{
	for (var i = 0; i < objectsToRemove.length; i++) 
	{
		$(objectsToRemove[i]).remove();
	}
}