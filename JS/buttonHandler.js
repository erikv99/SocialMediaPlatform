// File for handling button functions like close/exit and collapse/expand
function closeLoginContainer() 
{
	$(".login").remove();
}

function closeAlert() 
{
	$(".alert").remove();
}

function collapseSubject(containerID) 
{
	// In order for this to work each subjectContainer gets a identifier. which will be given to this function in order to collapse the correct sub-subjects
	// Checkign if we need to hide or show it (im aware toggle exists but i need this for other purposes as well)
	// Rotating the collapse img accordingly
	// NOTE: we also kind of rotate the add post (plus icon img) but since its the same upside down as normal its not noticable so just leaving that as is for now.
	if($(containerID).find(".subjectContainerSubRow").is(":visible")) 
	{
		$(containerID).find(".subjectContainerSubRow").hide();
		rotateImage($(containerID).find(".SCHeaderRowButtonImg"), 180);
	} 
	else 
	{
		$(containerID).find(".subjectContainerSubRow").show();
		rotateImage($(containerID).find(".SCHeaderRowButtonImg"), 0);
	}

}

function collapsePrimaryProposals() 
{
	alert("collapse prime");
}

function collapseSecondaryProposals() 
{
	alert("collapse sec");
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
