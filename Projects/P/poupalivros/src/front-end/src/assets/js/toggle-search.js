$('[data-toggle="search"]').click(function(e){
	e.preventDefault();
	var search = $('.search-mobile');
	var body = $('body');

	search.addClass('show');
	body.append('<div class="backdrop"></div>');

	$('.backdrop').click(function() {
		search.removeClass('show');

		$(this).fadeOut(600, function() {
			$(this).remove();
		});
	});

	setTimeout(function() {
		search.find('.form-control').focus();
	},600)

	$('.backdrop').fadeIn(600);
});
