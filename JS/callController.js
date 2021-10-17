function callController(controllerName) 
{
	var filePath = "../PHP/Controllers/" + controllerName + ".php";

	$.ajax({url: filePath, success: function(response) 
	{
		var jsonObj = JSON.parse(response);
		$("html").html(jsonObj.view);
	},
	error: function(xhr, status, error) 
	{
		var errorMessage = xhr.status + ': ' + xhr.statusText
		alert('Error - ' + errorMessage);
	}
	})
}