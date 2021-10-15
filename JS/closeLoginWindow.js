function hideLogin() 
{
	// Disabeling the blurry overlay
	$(".overlay").css({
		'-webkit-filter' : 'none',
		'filter' : 'none'
	})

	// Hiding the login window.
	$(".loginContainer").hide();
}

function showLogin() 
{
	// Disabeling the blurry overlay
	$(".overlay").css({
		'-webkit-filter' : 'blur(3px)',
		'filter' : 'blur(3px)'
	})

	// Hiding the login window.
	$(".loginContainer").show();
}