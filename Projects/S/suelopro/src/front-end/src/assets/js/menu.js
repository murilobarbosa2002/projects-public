$('[data-toggle="menu"]').click(function(){
	$('body').toggleClass('open-menu');
	$(this).toggleClass('active').blur();
});