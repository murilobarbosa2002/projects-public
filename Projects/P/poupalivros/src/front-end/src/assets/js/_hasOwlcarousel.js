let hasOwlCarousel = (function(){
	let owlSlider = $('.owl-carousel');

	$(document).on('owl:loaded', function() {
		let js 			= document.createElement('script');
		let css 		= document.createElement('link');

		css.href 	= path+'assets/css/owl.carousel.min.css';
		css.rel 	= 'stylesheet';

		js.src 		= path+'assets/js/owl.carousel.min.js';

		document.head.appendChild(css);
		document.body.appendChild(js);

		js.addEventListener('load', function(){
			owlCarouselReady();
		});

	});

	if(owlSlider.length > 0){
		$(document).trigger('owl:loaded');
	}
})();

function owlCarouselReady(){

	$.fn.myOwl = function() {

		return this.each(function(){
			let responsive 		= {};
			let owl 			= $(this);
			let childrenLenght 	= owl.children().length;

			let autoplay 		= owl.data('autoplay') 		|| false;
			let autoplayTimeout = owl.data('transition') 	|| 5000;
			let autoWidth		= owl.data('autowidth') 	|| false;
			let center			= owl.data('center') 		|| false;
			let loop 			= owl.data('loop') 			|| false;
			let margin 			= owl.data('margin') 		|| 0;
			let nav 			= owl.data('nav') 			|| false;
			let next 			= owl.data('next')  		|| 'fas fa-chevron-right';
			let prev 			= owl.data('prev')  		|| 'fas fa-chevron-left';
			let navText 		= [
				`<i class="${prev}" aria-label="Prev"></i><span class="sr-only">Prev</span>`,
				`<i class="${next}" aria-label="Next"></i><span class="sr-only">Next</span>`
			];
			let animateOut 		= owl.data('animate-out') 	|| false;
			let animateIn 		= owl.data('animate-in') 	|| false;
			let slideBy			= owl.data('slide-by') 		|| 1; // 'page' || 1
			let mouseDrag		= owl.data('drag') 			|| false;

			const hasloop 	= midia => {return loop ? (childrenLenght > midia) : false};

			responsive.xs = owl.data('xs') || 1;
			responsive.sm = owl.data('sm') || responsive.xs;
			responsive.md = owl.data('md') || responsive.sm;
			responsive.lg = owl.data('lg') || responsive.md;
			responsive.xl = owl.data('xl') || responsive.lg;

			owl.owlCarousel({
				autoplay 	    : autoplay,
				autoplayTimeout : autoplayTimeout,
				autoWidth       : autoWidth,
				center 			: center,
				nav 		    : nav,
				navText 	    : navText,
				slideBy			: slideBy,
				mouseDrag		: mouseDrag,
				responsive 	    : {
					0   : {
						items  : responsive.xs,
						loop   : hasloop(responsive.xs),
						margin : margin
					},
					576 : {
						items  : responsive.sm,
						loop   : hasloop(responsive.sm),
						margin : margin
					},
					768 : {
						items  : responsive.md,
						loop   : hasloop(responsive.md),
						margin : margin
					},
					992 : {
						items  : responsive.lg,
						loop   : hasloop(responsive.lg),
						margin : margin
					},
					1200 : {
						items  : responsive.xl,
						loop   : hasloop(responsive.xl),
						margin : margin
					}
				}
			}).on('owl.refresh.carousel', function() {
				var lazyImage = $(this).find('.cloned lazy-image');

				lazyImage.each(function() {

					Lazyimage.register($(this))
				})
			}).trigger('owl.carousel.refresh');

		});

	}

	$.fn.refreshOwl = function(childLenght) {
		return this.each(function() {
			var c 			= childLenght;
			var owl 		= $(this).data('owl.carousel')
			var options 	= owl.options;
			var responsive 	= options.responsive;

			for(let m in responsive) {
				var d = responsive[m];

				if(c <= d.items) {
					d.loop = false;
				}
			}

			$(this).trigger('refresh.owl.carousel');
		});

	}

	$.fn.replaceOwlContent = function(content) {
		return this.each(function() {

			$(this).trigger('replace.owl.carousel', content);


			$(this).refreshOwl();

			var imgs = $(this).find('lazy-image, lazyimage');

			Lazyimage.register(imgs);

			imgs.each(function() {
				this.addEventListener('DOMSubtreeModified', function() {
					$(this).addClass('loaded')
				})
			})
		});

	}

	$('.owl-carousel').myOwl();

	$('[data-owl]').each(function(){
		let direction 	= $(this).data('owl');
		let target 		= $(this).attr('href');
		let self  		= $(this);
		let children	= $(target).length;

		$(this).click(function(e){
			e.preventDefault();

			if(!$(this).hasClass('disabled')){
				$(target).trigger(`${direction}.owl.carousel`);
			}

		});

	});

	$('.owl-carousel').each(function(){
		let id 				= this.id;
		let exteralControls = $('a[href="#'+id+'"]');
		let prev 			= $(this).find('.owl-prev');
		let next 			= $(this).find('.owl-next');
		let count 			= 0;

		function check () {
			if(prev.hasClass('disabled')){
				exteralControls.each(function() {
					if($(this).data('owl') === 'prev') {
						$(this).addClass('disabled');
					}else{
						$(this).removeClass('disabled');
					}
				});

				count++
			}

			if(next.hasClass('disabled')){
				exteralControls.each(function() {
					if($(this).data('owl') === 'next') {
						$(this).addClass('disabled');
					}else{
						$(this).removeClass('disabled');
					}
				});

				count++
			}

		}

		exteralControls.addClass('ready');

		check();

		$(this).on('changed.owl.carousel', function(){
			count = 0;
			check();
		});
	});

}
