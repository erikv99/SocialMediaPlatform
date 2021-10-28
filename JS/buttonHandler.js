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
}

function expandSubject() 
{

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