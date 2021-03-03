$.fn.responsiveBsCarousel = function(){
	let jaWrapCarousel = false;

	function getData(el){
		let data = {};

		data.xs = el.data('xs') || 1;
		data.sm = el.data('sm') || data.xs;
		data.md = el.data('md') || data.sm;
		data.lg = el.data('lg') || data.md;
		data.xl = el.data('xl') || data.lg;

		return data;
	}

	return this.each(function(index, el){
		let carousel 	= $(this)
		let responsive 	= getData(carousel);
		let inner 		= $(this).find('.carousel-inner');
		let indicators 	= carousel.find('.carousel-indicators');
		let items 		= inner.children();
		let id 			= carousel.attr('id');

		if(!id){
			carousel.attr('id', 'carousel-responsive-'+index);

			id = 'carousel-responsive-'+index;
		}

		function wrapCarousel (){
			inner.find('.carousel-item > .row > *').unwrap('.row');
			inner.find('.carousel-item > *').unwrap('.carousel-item');
			indicators.html('');

			for(var i=0; i < items.length; i++){
				carousel.find('.carousel-inner > *')
					.slice(i, (i + responsive[midiaSize]))
					.wrapAll('<div class="carousel-item"></div>')
					.wrapAll('<div class="row"></div>')
			}

			inner.find('.carousel-item:first-child').addClass('active');

			inner.find('.carousel-item').each(function(index, el){
				let indicator = `<li data-target="#${id}" data-slide-to="${index}" ${index == 0 ? 'class="active"' : ''}></li>`;

				indicators.append(indicator);
			});
		}

		wrapCarousel ();

		$(window).resize(function(){
			if(jaWrapCarousel) return;

			setTimeout(function(){
				jaWrapCarousel = false;
			},100);

			wrapCarousel ();
		});

	});
}

$('.carousel-responsive').responsiveBsCarousel();

$('.carousel').each(function(){

	if($(this).find('.carousel-item').length <= 1) {
		$(this).find('.controles').hide();
	}
});
