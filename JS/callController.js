function callController(controllerName) 
{
	var filePath = "../PHP/Controllers/" + controllerName + ".php";

	$.ajax({url: filePath, success: function(response) 
	{
		console.log(response);
		var jsonObj = JSON.parse(response);
		console.log(jsonObj.view);
		window.location.href = "empty.php";

		window.onload = function()
		{
			$("body").html(jsonObj.view);
		}

		
	},
	error: function(xhr, status, error) 
	{
		var errorMessage = xhr.status + ': ' + xhr.statusText
		alert('Error - ' + errorMessage);
	}
	})
}