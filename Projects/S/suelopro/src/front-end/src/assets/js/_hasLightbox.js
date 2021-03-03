let hasLightbox =  (function(){
	let lightboxItens = $('[data-lightbox]');

	if(lightboxItens.length > 0){
		let css = document.createElement('link');

		css.rel = 'stylesheet';
		css.href = 'assets/css/lightbox.min.css';
		css.type = 'text/css';

		document.head.appendChild(css);

		let js = document.createElement('script');

		js.defer = true;
		js.src = 'assets/js/lightbox.min.js';

		document.body.appendChild(js);
	}
})();