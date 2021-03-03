let hasOwlCarousel = (function(){
	let owlSlider = $('.owl-carousel');

	if(owlSlider.length > 0){
		let js = document.createElement('script');

		js.src = 'assets/js/owl.carousel.min.js';

		document.body.appendChild(js);

		js.addEventListener('load', function(){
			onOwlCarouselReady();
		});
	}
})();