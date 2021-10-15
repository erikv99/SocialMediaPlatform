// GENERAL INFO
// Login and register are the same container, main difference is one has a extra label/input

function hideLogin() 
{
	// Disabeling the blurry overlay
	$(".overlay").css({
		'-webkit-filter' : 'none',
		'filter' : 'none'
	})

	// Hiding the login/register window.
	$(".loginFormContainer").hide();
	$(".confirmPassword").hide();
}

function showLogin() 
{
	// Disabeling the blurry overlay
	$(".overlay").css({
		'-webkit-filter' : 'blur(3px)',
		'filter' : 'blur(3px)'
	})

	// Hiding the login/register window.
	$(".loginFormContainer").show();
}

function showRegister() 
{
	// Disabeling the blurry overlay
	$(".overlay").css({
		'-webkit-filter' : 'blur(3px)',
		'filter' : 'blur(3px)'
	})

	// Hiding the login/register window.
	$(".loginFormContainer").show();
	$(".confirmPassword").show();
}