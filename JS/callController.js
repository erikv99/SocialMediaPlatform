function callController(placeMentTag, controllerName) 
{
	var filePath = "../PHP/Controllers/" + controllerName + ".php";

	$.ajax({url: filePath, success: function(response) 
	{
		console.log(response);
		var jsonObj = JSON.parse(response);
		alert(jsonObj.indexViewRequired);
		if (jsonObj.indexViewRequired == true) 
		{
			alert("is true");
			window.location.replace("../index.php");
		}

		$(placeMentTag).append(jsonObj.view);	
	},
	error: function(xhr, status, error) 
	{
		var errorMessage = xhr.status + ': ' + xhr.statusText
		alert('Error - ' + errorMessage);
	}
	})

	return false;
}