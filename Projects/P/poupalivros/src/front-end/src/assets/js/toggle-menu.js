$('[data-toggle="menu"]').click(function(e){
	e.preventDefault();
	var main = $('.main-topo');
	var body = $('body');

	main.addClass('show');
	body.append('<div class="backdrop"></div>');

	$('.backdrop').click(function() {
		main.removeClass('show');

		$(this).fadeOut(600, function() {
			$(this).remove();
		});
	});

	$('.backdrop').fadeIn(600);
});
