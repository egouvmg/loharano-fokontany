$(function () {
	$('.main-menu > li > a').click(function(e){
		e.preventDefault();
		
		if ($(this).next().is(':visible'))
			$(this).next().hide();
		else $(this).next().show();	
	});
});
