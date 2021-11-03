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

		// Parsing the json to a object
		var jsonObj = JSON.parse(response); 

		// Checking if the jsonObj contains a "objectsToRemove" key. (only returned if needed)
		if (jsonObj.hasOwnProperty("objectsToRemove")) 
		{
			console.log("removing elements from view");
			// removing any elements from the view if needed.
			removeElementsFromView(jsonObj.objectsToRemove);
		}


		console.log("View: " + jsonObj.view);

		// Getting our view from our object and appending it (placing it before) the placementTag
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

// Function to remove multiple elements from the view, requires an array with the className of each object to be removed
function removeElementsFromView(objectsToRemove) 
{
	for (var i = 0; i < objectsToRemove.length; i++) 
	{
		$(objectsToRemove[i]).remove();
	}
}