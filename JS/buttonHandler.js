// File for handling button functions like close/exit and collapse/expand
function closeLoginContainer() 
{
	$(".login").remove();
}

function closeAlert() 
{
	stopAlertTimer();
	$(".alert").remove();
}

function collapseSubject(containerID) 
{
	// In order for this to work each subjectContainer gets a identifier. which will be given to this function in order to collapse the correct sub-subjects
	// Checkign if we need to hide or show it (im aware toggle exists but i need this for other purposes as well)
	// Rotating the collapse img accordingly
	// NOTE: we also kind of rotate the add post (plus icon img) but since its the same upside down as normal its not noticable so just leaving that as is for now.
	var container = $(containerID);
	var subRow = container.find(".subjectContainerSubRow");
	var img = container.find(".SCHeaderRowButtonImg")

	if(subRow.is(":visible")) 
	{
		subRow.hide();
		rotateImage(img, 180);
	} 
	else 
	{
		subRow.show();
		rotateImage(img, 0);
	}

}

// Could have made collapse primary and secondary in to one function but i think this is a bit more cleaner.
function collapsePrimaryProposals() 
{
	var subjectContainer = $(".primaryProposals");
	var contentRow = subjectContainer.find(".subjectContainerContentRow");
	var img = subjectContainer.find(".SCHeaderRowButtonImg");

	if (contentRow.is(":visible")) 
	{
		contentRow.hide();
		rotateImage(img, 180);
	}
	else 
	{
		contentRow.show();
		rotateImage(img, 0);
	}
}

function collapseSecondaryProposals() 
{
	var subjectContainer = $(".secondaryProposals");
	var contentRow = subjectContainer.find(".subjectContainerContentRow");
	var img = subjectContainer.find(".SCHeaderRowButtonImg");

	if (contentRow.is(":visible")) 
	{
		contentRow.hide();
		rotateImage(img, 180);
	}
	else 
	{
		contentRow.show();
		rotateImage(img, 0);
	}
}

function collapseSidebar() 
{
	$(".expandedSidebar").fadeOut("fast");
	$(".collapsedSidebar").fadeIn("slow");
	$(".content").css("padding-left", "5em");
}

function expandSidebar() 
{
	$(".collapsedSidebar").fadeOut("fast");
	$(".expandedSidebar").fadeIn("slow");
	$(".content").css("padding-left", "14em");
}

function logout() 
{
	$.ajax({

		url: "Ajax/logout.ajax.php",
		method: "GET",

		success: function() 
		{
			// since we already know we logged the user out we dont do a loginCheck but just call the userNotLoggedIn function directly
			userIsNotLoggedIn();

			// refreshing the page incase anything in the view needs to change
			refreshPage();
		},
		error: function(xhr, status, error) 
		{
			var errorMessage = xhr.status + ': ' + xhr.statusText;
			console.log(errorMessage);
		}
	});
}

function loadSecondaries() 
{
	var primarySubject = $("#primaryToLoadSecondariesFrom").val();
	//alert(primarySubject);

	data = { "primarySubject" : primarySubject};


	$.ajax(
	{
		url: "Ajax/getSecondarySubjects.ajax.php",
		method: "POST",
		data : data,

		success: function(response) 
		{

			// Parsing the json response into a object
			var obj = JSON.parse(response);

			// Getting the secondarySubjects array and putting it in a seperate var.
			var secondarySubjects = obj.secondarySubjects;
			
			var output = [];

			for (var i = 0; i < secondarySubjects.length; i++) 
			{
				output.push("<option value='"+ secondarySubjects[i] +"'>" + secondarySubjects[i] + "</option>");
			}

			$("#secondaryToDelete").html(output.join(""));

		},
		error: function(xhr, status, error) 
		{
			var errorMessage = xhr.status + ': ' + xhr.statusText;
			console.log(errorMessage);
		}
	});
}
