let _midiaSize = (function(){
	let jaCalcMidia = false;
	
	window.midiaSize  = 'xs';

	function verifyMidia(){
		let w = window.innerWidth;

		if(w < 576){
			window.midiaSize = 'xs';
		}

		if(w >= 576){
			window.midiaSize  = 'sm';
		}

		if(w >= 768){
			window.midiaSize = 'md';
		}

		if(w >= 992){
			window.midiaSize = 'lg';
		}

		if(w >= 1200){
			window.midiaSize = 'xl';
		}

	}

	verifyMidia();

	$(window).resize(function(){
		if(jaCalcMidia) return;

		setTimeout(function(){
			jaCalcMidia = false;
		},100);

		verifyMidia();
	});

})();