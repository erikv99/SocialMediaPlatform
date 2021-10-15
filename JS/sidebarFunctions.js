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

