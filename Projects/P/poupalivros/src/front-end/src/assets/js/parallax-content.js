/*

	Para poder fazer o parallax do conteúdo, add a classe ".parallax-content" á seção pai,
	e no css do alvo da animação coloque a seguinte propriedade:

	<div class="section parallax-content">
		<div class="inner">...</div>
	</div>

	<style lang="scss">
		.section {
			.inner{
				transform: translateY( var(--parallax-y) );
			}
		}
	</style>

*/

var parallaxContent = (function() {
	var ja 			= false;
	var containers 	= document.querySelectorAll('.parallax-content');

	function parallax () {

		containers.forEach(function(container) {
			var trigger;

			if(container.hasAttribute('data-trigger')) {
				trigger = document.querySelector(container.getAttribute('data-trigger'));
			}else{
				trigger = window;
			}

			function verify () {
				var rect 			= container.getBoundingClientRect().top;
				var offset 			= 0;

				if(container.hasAttribute('data-offset')){
					var elementOffset   = container.getAttribute('data-offset');
					var offset 			= document.querySelector(elementOffset).getBoundingClientRect().height;
				}



				if(midiaSize == 'xs' || midiaSize == 'sm' || midiaSize == 'md') {
					if(rect <= offset) {

						container.setAttribute('style', `--parallax-y: ${parseInt((rect - offset)/-2)}px`);

					}else{
						container.setAttribute('style', `--parallax-y: 0px`);
					}
				}else{
					if(rect <=0) {
						container.setAttribute('style', `--parallax-y: ${parseInt((rect)/-2)}px`);
					} else{
						container.setAttribute('style', `--parallax-y: 0px`);
					}
				}
			}

			verify();

			trigger.addEventListener('scroll', function() {
				if(ja) return;

				setTimeout(function() {
					ja = false;
				}, 100);

				verify();
			});
		});
	}

	parallax();


})();
