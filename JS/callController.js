function callController(placeMentTag, controllerName, data = "") 
{
	// Since data is just a single value we have to put it in array form
	var dataToSend = {data : data};
	this.sendAjaxRequest(placeMentTag, controllerName, dataToSend);
}

// Function for calling a controller and sending data with it. 

// Function for calling a controller from inside a form action
function callControllerFromForm(placeMentTag, controllerName, formID) 
{
	var formData = $("." + formID).serialize();
	this.sendAjaxRequest(placeMentTag, controllerName, formData);
}

// Function for calling a subject page controller. we need to know which subject so its a seperate function in this case
//function callSubjectPageController(placeMentTag, controllerName, subject) 
//{
//	this.sendAjaxRequest(placeMentTag, controllerName, subject)
//}

function sendAjaxRequest(placeMentTag, controllerName, data) 
{
	var filePath = "../PHP/Controllers/" + controllerName + ".php";
	console.log("callController to " + controllerName);
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