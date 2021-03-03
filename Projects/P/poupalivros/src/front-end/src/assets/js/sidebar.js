$('[data-toggle="sidebar"]').click(function(e) {
	e.preventDefault();
	var label 		= $(this).attr('aria-label');
	var expanded 	= $(this).attr('aria-expanded');

	$('.wrap-content').toggleClass('show');

	var newLabel 	= label === 'mostrar sidebar' ? 'ocultar sidebar' : 'mostrar sidebar';
	var newExp 		= expanded === 'false' ? 'true' : 'false';

	$(this).attr('aria-label', newLabel)
		.attr('aria-expanded', newExp)
		.blur();
});
