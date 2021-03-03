var Destaques = (function() {
	var ja 		= false;
	var target 	= document.querySelector('.fique-por-dentro .controles-mobile') ;

	if(target) {
		verificar();

		$(window).scroll(function() {
			if(ja) return;

			setTimeout(function() {
				ja = false;
			}, 100);

			verificar();
		});
	}

	function verificar (){
		var parentRect 	= target.parentNode.getBoundingClientRect();
		var rect 		= target.getBoundingClientRect();

		if(parentRect.top <= 70) {
			$(target).addClass('fx');

			if(parentRect.top <= (-parentRect.height + 130)) {
				$(target).removeClass('fx')
			}
		}

		else {
			$(target).removeClass('fx');
		}
	}

})();
