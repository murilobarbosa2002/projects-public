var midiaSize = 'xs';

(function() {
	var jaVerify = false;

	verifyMidia();

	window.addEventListener('resize', function() {
		if(jaVerify) return;

		setTimeout(() => {
			jaVerify = false;
		}, 100);

		verifyMidia();
	});

	function verifyMidia () {
		var w = window.innerWidth;

		if(w < 500) {
			midiaSize = 'xs';
		}

		if(w >= 500) {
			midiaSize = 'sm';
		}

		if(w >= 768) {
			midiaSize = 'md';
		}

		if(w >= 992) {
			midiaSize = 'lg';
		}

		if(w >= 1200) {
			midiaSize = 'xl';
		}
	}

})();

const BODY 	= document.body;
const APP 	= document.querySelector('#app');
const path 	= basePath();

function basePath () {
	let p = '';

	if($('body').data('path')) {
		p = $('body').data('path') + '/';
	}

	return p;
}

