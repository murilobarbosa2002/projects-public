var Lazyimage = {
	jaLazy : false
};

Lazyimage.verify = function(){
	$('.lazyimage:not(.loaded)').each(function(){
		if(this.getBoundingClientRect().top <= (window.innerHeight + 200)){

			var img 		= document.createElement('img');
			var lazyimage 	= $(this);

			img.src 	= $(this).data('src');
			img.width 	= $(this).data('width');
			img.height 	= $(this).data('height');
			img.alt 	= $(this).data('alt');

			if($(this).data('srcset')){
				img.srcset = $(this).data('srcset');
			}

			if($(this).data('sizes')){
				img.sizes = $(this).data('sizes');
			}

			var canvas = this.querySelector('.lazyimage-canvas');

			canvas.appendChild(img);

			lazyimage.addClass('loaded loading');

			img.addEventListener('load', function(){
				lazyimage
					.removeClass('loading')
					.removeAttr('data-width data-src data-height data-srcset data-alt');
			});

			img.addEventListener('error', function() {
				var errorMessage = `<div class="lazyimage-error">
					<svg viewBox="0 0 79.375 79.375" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M28.728 22.708a6.608 6.608 0 0 0-6.606-6.606c-3.647 0-6.606 2.959-6.606 6.606s2.959 6.606 6.606 6.606a6.608 6.608 0 0 0 6.606-6.606zm35.23 13.212L49.645 21.607 32.03 39.223l-5.505-5.505-11.01 11.01v6.606h48.443zm3.303-24.222c.585 0 1.1.516 1.1 1.101v41.837c0 .585-.515 1.1-1.1 1.1H12.21c-.584 0-1.1-.515-1.1-1.1V12.799c0-.585.516-1.1 1.1-1.1zm5.505 1.101c0-3.028-2.477-5.505-5.505-5.505H12.21c-3.027 0-5.504 2.477-5.504 5.505v41.837c0 3.027 2.477 5.505 5.505 5.505H67.26c3.028 0 5.505-2.478 5.505-5.505z" aria-label="" fill="currentcolor"/> <path d="M6.62 67.246h.473v4.8H6.62zM8.605 67.24h.59l1.882 3.604 1.86-3.605h.59v4.807h-.439l-.006-4.147L11.2 71.53h-.26L9.05 67.9v4.147h-.446zM18.626 72.046l-.57-1.278h-2.664l-.563 1.278h-.508l2.163-4.8h.494l2.163 4.8zm-3.048-1.703h2.293l-1.154-2.596zM23.188 69.697h.418v1.757q-.35.296-.817.467-.46.165-.94.165-.68 0-1.257-.33-.57-.329-.906-.892-.337-.563-.337-1.23t.337-1.221.913-.88q.584-.329 1.27-.329.488 0 .941.172.46.172.81.48l-.274.337q-.296-.275-.68-.419-.385-.15-.797-.15-.556 0-1.023.274-.467.268-.741.728t-.275 1.009q0 .556.275 1.023.274.46.741.735.474.267 1.03.267.344 0 .68-.11.343-.116.632-.322zM25.009 67.246h3.213v.426h-2.74v1.717h2.452v.425h-2.451v1.806h2.828v.426H25.01zM34.845 67.246h.467v4.8h-.502l-2.973-4.065v4.065h-.473v-4.8h.5l2.98 4.065zM38.875 67.204q.687 0 1.256.33.577.323.914.879.336.556.336 1.222 0 .666-.336 1.23-.337.562-.914.892-.57.33-1.256.33t-1.263-.33q-.57-.33-.907-.893-.336-.563-.336-1.229t.336-1.222q.337-.556.907-.879.576-.33 1.263-.33zm.007.426q-.55 0-1.016.268-.467.268-.742.728t-.275 1.01q0 .548.275 1.015t.742.742q.467.268 1.016.268.542 0 1.002-.268.467-.275.742-.742.275-.467.275-1.016t-.275-1.01-.742-.727q-.46-.268-1.002-.268zM41.696 67.24h3.646v.432h-1.586v4.374h-.474v-4.374h-1.586zM48.06 67.246h3.008v.426h-2.533v1.847h2.259v.426h-2.26v2.1h-.473zM53.947 67.204q.687 0 1.257.33.576.323.913.879.336.556.336 1.222 0 .666-.336 1.23-.337.562-.913.892-.57.33-1.257.33t-1.263-.33q-.57-.33-.907-.893-.336-.563-.336-1.229t.336-1.222.907-.879q.577-.33 1.263-.33zm.007.426q-.55 0-1.016.268-.467.268-.742.728t-.274 1.01q0 .548.274 1.015t.742.742q.467.268 1.016.268.542 0 1.002-.268.467-.275.742-.742.275-.467.275-1.016t-.275-1.01-.742-.727q-.46-.268-1.002-.268zM57.865 70.095q0 .742.399 1.154.405.412 1.119.412t1.112-.412.398-1.154V67.24h.474v2.856q0 .934-.528 1.463-.522.528-1.456.528-.934 0-1.463-.528t-.528-1.463V67.24h.473zM66.254 67.246h.467v4.8h-.5l-2.974-4.065v4.065h-.474v-4.8h.502l2.98 4.065zM70.173 67.246q.686 0 1.25.316.57.316.892.872.33.55.33 1.216t-.33 1.215q-.323.55-.893.865-.57.316-1.263.316h-1.916v-4.8zm.014 4.374q.542 0 .995-.26t.714-.708q.268-.453.268-1.002t-.268-1.003q-.268-.453-.728-.714-.453-.26-1.002-.26h-1.449v3.947z"
							fill="currentcolor"/>
					</svg>
				</div>`;

				lazyimage.removeClass('loading');

				canvas
					.removeChild(img)
					.insertAdjacentHTML('afterbegin', errorMessage);
			});
		}
	});
}

Lazyimage.register = function(elemento) {
	$(elemento).each(function(){
		var lazyImageData = {
			src 	: $(this).attr('src') || '',
			width 	: parseInt($(this).attr('width')) || 0,
			height 	: parseInt($(this).attr('height')) || 0,
			alt 	: $(this).attr('alt') || ''
		};
		var scale		= (lazyImageData.height / lazyImageData.width) * 100;
		var lazyimage 	= document.createElement('div');
		var wrapper 	= document.createElement('div');
		var canvas 		= document.createElement('div');

		$(lazyimage).attr('data-src',lazyImageData.src);
		$(lazyimage).attr('data-alt',lazyImageData.alt);
		$(lazyimage).attr('data-width',lazyImageData.width);
		$(lazyimage).attr('data-height',lazyImageData.height);

		if($(this).attr('srcset')){
			$(lazyimage).attr('data-srcset',$(this).attr('srcset'));
		}

		if($(this).attr('sizes')){
			$(lazyimage).attr('data-sizes',$(this).attr('sizes'));
		}

		$(lazyimage)
			.addClass('lazyimage')
			.css('width', lazyImageData.width);

		$(wrapper)
			.addClass('lazyimage-wrapper')
			.css('padding-bottom', `${scale}%`);

		$(canvas).addClass('lazyimage-canvas');

		wrapper.appendChild(canvas);
		lazyimage.appendChild(wrapper);

		this.parentNode.insertBefore(lazyimage, this);

		this.outerHTML = `<!-- ${this.outerHTML} -->`;
	});
};

Lazyimage.start = (function() {
	var style = document.createElement('style');

	style.innerText = '.lazyimage{'+
		'max-width: 100%;'+
		'position: relative;'+
		'overflow: hidden;'+
	'}'+

	'@keyframes loadingLazyimage {'+
		'0% {transform: translate(-50%, -50%) rotate(0deg)}'+
		'100% {transform: translate(-50%, -50%) rotate(359deg)}'+
	'}'+

	'@-webkit-keyframes loadingLazyimage {'+
		'0% {transform: translate(-50%, -50%) rotate(0deg)}'+
		'100% {transform: translate(-50%, -50%) rotate(359deg)}'+
	'}'+

	'.lazyimage:not(.loaded){background: transparent}'+

	'.lazyimage img{opacity: 0;transition:opacity 0.3s linear;max-width:100%;height:auto}'+
	'.lazyimage.loaded img{opacity: 1}'+

	'.lazyimage-canvas{'+
		'position: absolute;'+
		'width: 100%;'+
		'height: 100%;'+
		'left : 0;'+
		'top : 0;'+
	'}'+

	'.lazyimage:not(.loaded) .lazyimage-canvas:before{'+
		'content:\'\';'+
		'width: 30px;'+
		'height: 30px;'+
		'border:5px solid #00A76E;'+
		'border-top-color: transparent;'+
		'border-radius: 100%;'+
		'display: block;'+
		'position:absolute;'+
		'left: 50%;'+
		'top: 50%;'+
		'transform: translate(-50%, -50%);'+
		'animation: loadingLazyimage 1s linear infinite'
	'}';

	document.head.appendChild(style);

	Lazyimage.register('lazy-image, lazyimage');

	Lazyimage.verify();

	$(window).scroll(function(){
		if(Lazyimage.jaLazy) return;

		setTimeout(function(){
			Lazyimage.jaLazy = false;
		}, 100);

		Lazyimage.verify();
	});

})();


Lazyimage.info = function() {
	let log 		= console.log;
	let cssTitle 	= 'background: #0277BD;color: #FFF;padding: 0.3em 0.6em;font-size: 14px';
	let tag			= 'color: #C42E36';
	let attribute 	= 'color: green';
	let aspas 		= 'color: #F56115';
	let value 		= 'color: #1B4762';
	let text		= 'color: #222';

	log('%cSobre o LazyImage <lazy-image></lazy-image>', cssTitle);
	log('\n');
	log('O elemento %c<lazy-image></lazy-image>%c, é uma medida grotesca de usar o WEb Components enquanto as merdas dos browsers não dão total suporte para a API original.', tag, 'color: inherit');
	log('Este componete, visa %c"atrasar" %co carregamento das imagens para economizar recursos de banda optimizando, assim, o carregamento da página.','font-weight: 700', 'font-weight: 400')
	log('A sua utilização é como no exemplo abaixo:')
	log('%c<lazy-image ',tag);
	log('  %csrc=%c"%cimagem.jpg%c"',attribute, aspas, value, aspas);
	log('  %cwidth=%c"%c250%c"',attribute, aspas, value, aspas);
	log('  %cheight=%c"%c250%c"',attribute, aspas, value, aspas);
	log('  %calt=%c"%cNome/Descrição%c"',attribute, aspas, value, aspas);
	log('  %csrcset=%c"%cimage-celular.jpg 240w, image-tablet.jpg 500w, image-netbook.jpg 900w, image-desktop.jpg 1100w%c"',attribute, aspas, value, aspas);
	log('  %csizes=%c"%c(max-width: 499px) 240w, (max-width: 899px) 500w, (max-width: 1200px) 900w, (min-with: 1200px) 1100w%c" %c>',attribute, aspas, value, aspas,tag);
	log('%c</lazy-image>',tag);

	log('')
	log('%cObservação: %cOs attributos src, width e height são %cobrigatórios. %cJá o restante é meramente opcional','color:#FFF;background:#FE3535;padding:0.3em 0.4em;margin-right:1em', 'color: #444;padding:0', 'font-weight:700','font-weight:400');
	log('')
	log('%cCriou um lazy-image de forma dinâmica e deseja registrá-lo?','font-weight:bold;font-size: 1.1428571428571428em;');
	log('Para tal, basta executar o seguinte código abaixo que é %cGG', 'font-weight:bold');
	log('%c<script>',tag);
	log('  %cLazyimage%c.%cregister(%c"lazy-image"%c);', value, text,value,attribute,value);
	log('%c</script>',tag);
}