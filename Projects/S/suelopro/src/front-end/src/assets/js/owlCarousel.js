function onOwlCarouselReady(){

	$('.owl-carousel').each(function(){
		let responsiveList 	= {};

		responsiveList.xs 	= $(this).data('xs') || 1;
		responsiveList.sm 	= $(this).data('sm') || responsiveList.xs;
		responsiveList.md 	= $(this).data('md') || responsiveList.sm;
		responsiveList.lg 	= $(this).data('lg') || responsiveList.ms;
		responsiveList.xl 	= $(this).data('xl') || responsiveList.lg;

		let childrenLength 	= $(this).children().length;
		let margin 			= $(this).data('margin') || 0;
		let autoplay 		= $(this).data('autoplay');
		let nav 			= $(this).data('nav');
		let prev			= $(this).data('prev');
		let next			= $(this).data('next');
		let navText			= [];

		if(prev || next) {
			navText = [
				`<i class="${prev}"></i>`,
				`<i class="${next}"></i>`
			];
		}

		$(this).owlCarousel({
			autoplay	: autoplay,
			nav 		: nav,
			navText 	: navText,
			responsive 	: {
				0 : {
					items 	: responsiveList.xs,
					loop  	: childrenLength > responsiveList.xs,
					margin	: margin || 0
				},
				576 : {
					items 	: responsiveList.sm,
					loop  	: childrenLength > responsiveList.sm,
					margin	: margin || 0
				},
				768 : {
					items 	: responsiveList.md,
					loop  	: childrenLength > responsiveList.md,
					margin	: margin || 0
				},
				992 : {
					items 	: responsiveList.lg,
					loop  	: childrenLength > responsiveList.lg,
					margin	: margin || 0
				},
				1200 : {
					items 	: responsiveList.xl,
					loop  	: childrenLength > responsiveList.xl,
					margin	: margin || 0
				},
			}
		});
	});


	$('[data-owl]').click(function(e){
		e.preventDefault();

		let owl 	= $(this).data('owl');
		let target	= $(this).attr('href');

		$(target).trigger(owl+'.owl.carousel');
	});
}