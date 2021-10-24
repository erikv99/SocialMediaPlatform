// GENERAL INFO
// Login and register are the same container, main difference is one has a extra label/input

// Made for readability. 
function closeRegisterContainer() 
{
	this.closeLoginContainer();
}

function closeLoginContainer() 
{
	$(".login").remove();
}