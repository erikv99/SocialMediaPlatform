function callController(placeMentTag, controllerName) 
{
	var filePath = "../PHP/Controllers/" + controllerName + ".php";

	$.ajax({url: filePath, success: function(response) 
	{
		console.log(response);
		var jsonObj = JSON.parse(response);
		$(placeMentTag).append(jsonObj.view);	
	},
	error: function(xhr, status, error) 
	{
		var errorMessage = xhr.status + ': ' + xhr.statusText
		alert('Error - ' + errorMessage);
	}
	})
}