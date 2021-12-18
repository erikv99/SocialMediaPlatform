function callController(placeMentTag, controllerName, controllerData = "") 
{

	// Since data is just a single value we have to put it in array form
	var dataToSend = {data : controllerData};

	// Handeling the actions regarding a eventual refresh page. we need to save some info in some cases
	this.saveCallControllerInfo(placeMentTag, controllerName, controllerData);
	
	this.sendAjaxRequest(placeMentTag, controllerName, dataToSend);
} 

// Function for calling a controller from inside a form action
function callControllerFromForm(placeMentTag, controllerName, formID) 
{
	var formData = $("." + formID).serialize();
	this.sendAjaxRequest(placeMentTag, controllerName, formData);
}


function sendAjaxRequest(placeMentTag, controllerName, data) 
{
	var filePath = "../PHP/Controllers/" + controllerName + ".php";

	console.log("callController to " + filePath);
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

			//console.log("Content after parse:\n" + jsonObj.view);

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
		error: function(jqXHR, exception) 
		{
			var msg = '';
        	if (jqXHR.status === 0) {
        	    msg = 'Didnt connect, verify Network.';
        	} else if (jqXHR.status == 404) {
        	    msg = 'Requested page not found. [404]';
        	} else if (jqXHR.status == 500) {
        	    msg = 'Internal Server Error [500].';
        	} else if (exception === 'parsererror') {
        	    msg = 'Requested JSON parse failed.';
        	} else if (exception === 'timeout') {
        	    msg = 'Time out error.';
        	} else if (exception === 'abort') {
        	    msg = 'Ajax request aborted.';
        	} else {
        	    msg = 'Uncaught Error.\n' + jqXHR.responseText;
        	}
			console.log(msg);
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

// Checks if the callController info needs to be saved, this is the case for basically all controllers except a few specific ones.
// Reason for saving this is when a page request is needed we need to know which controller was last called.
function saveCallControllerInfo(placeMentTag, controllerName, controllerData) 
{
	var excludedControllers = [
	"loginController",
	"registerController",
	"alertController",
	"createPostController",
	"proposalController",
	"headerController"
	];
	
	// Checking if the controller name is one of the excluded controllers, returning if this is the case
	if (excludedControllers.includes(controllerName)) { return; }

	// If its the post page controller we ONLY want to save it if the arguments dont contain the word EDIT
	// Reason is that if its edit and someone logs out, the page will be refreshed, if the call containing edit gets saved this is the view which is called.
	// in simpler terms if user logges out while in edit mode he will still get a edit view if we save that controller call
	if (controllerName == "postPageController" && controllerData.includes("edit")) { return; }
	
	// Parsing the data and manually escpaing the semicolumns since it messes with our JSON
	controllerData = JSON.stringify(controllerData);	
	controllerData = controllerData.replace(/;/g, "escapedSC");

	// Saving the current controller call in a cookie for later usage if needed.
	document.cookie = "lastControllerPlacementTag=" + placeMentTag;
	document.cookie = "lastControllerName=" + controllerName;
	document.cookie = "lastControllerData=" + controllerData;
}

function decodeHtml(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}