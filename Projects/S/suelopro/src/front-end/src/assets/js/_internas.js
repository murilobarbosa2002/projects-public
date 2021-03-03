$('select.select-custom').each(function(index, el){
	let name 	= $(this).attr('name');
	let id 		= $(this).attr('id');

	let defaultText 	= $(this).find('option[value=""]').html() || 'Selecione';
	let options 		= '';

	let template 		= `
		<div class="select-custom">
			<input class="form-control output" placeholder="{{defaultText}}" disabled>

			<div class="drop-options">
				<input type="text" name="filtro" data-target="#options-list-${index}" id="${id}"/>

				<ul id="options-list-${index}">
					{{options}}
				</ul>
			</div>
		</div>
	`;

	$(this).find('option').each(function(i,e){
		if($(this).val() != ''){

			let text 	= $(this).html();
			let val 	= $(this).attr('value');

			let option 	= `
				<li>
					<input type="radio" id="${id}-option-${i}" name="${name}" value="${val}"/>
					<label for="${id}-option-${i}">${text}</label>
				</li>
			`;

			options += option;
		}
	});

	template = template.replace(/{{defaultText}}/g, defaultText);
	template = template.replace(/{{options}}/g, options);

	$(this).after(template);
	$(this).remove();
});

$('.md-form').each(function(){
	if($(this).find('.form-control').val() != ''){
		$(this).addClass('active');
	}
});

$('.md-form .form-control, .md-form input, .md-form textarea, .md-form select').focus(function(){
	$(this).parents('.md-form').addClass('active');
});

$('.md-form .form-control').blur(function(){
	if($(this).val() == ''){
		$(this).parents('.md-form').removeClass('active');
	}
});

$('.select-custom input[name="filtro"]').focus(function(){
	$(this).parents('.select-custom').addClass('open');
});

$('.select-custom input[name="filtro"]').keyup(function(){
	function normalizeString(string){
		return string.toUpperCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "");
	}

	let value 	= $(this).val();
	let filtro 	= normalizeString(value);
	let target 	= $(this).data('target');

	$(target+' label').each(function(){
		let text 	= $(this).text();
		let option 	= normalizeString(text);
		let parent 	= $(this).parent('li');

		if(option.indexOf(filtro) < 0){
			parent.hide();
		}else{
			parent.removeAttr('style');
		}
	});
});

$(document).click(function(){
	$('.select-custom').removeClass('open');
	$('.select-custom input').blur();
});

$('.select-custom').click(function(e){
	e.stopPropagation();

	$(this).addClass('open');
	$(this).find('input[name="filtro"]').focus();
})

$('.select-custom input[type="radio"]').on('change', function(){
	let output 	= $(this).parents('.select-custom').find('.output');
	let text 	= $(this).siblings('label').text();
	let selectCustom = output.parents('.select-custom');

	output.text(text)
	output.val(text).change();
	output.parents('.md-form').addClass('active');
	selectCustom.removeClass('open');

	selectCustom.find('input[name="filtro"]').val('').change();

	selectCustom.find('li').removeAttr('style');
});

var hasDatePicker = (function(){
	var datePicerElements = $('.datepicker');
	var has = false;

	if(datePicerElements.length > 0){
		if(!has){
			var rout = window.location.protocol + '//' + window.location.host;
			var css = document.createElement('link');

			css.rel 	= 'stylesheet';
			css.type 	= 'text/css';
			css.href	= `${rout}/assets/css/bootstrap-datepicker.min.css`;

			document.head.appendChild(css);

			var js = document.createElement('script');

			js.src = `${rout}/assets/js/bootstrap-datepicker.min.js`;

			document.body.appendChild(js);

			js.addEventListener('load', function(){
				datePicerElements.datepicker({
					format: 'dd/mm/yyyy'
				})
			});
		}
	}
})();

let masonry = (function(){
	let masonryRow = $('.masonry-row');

	if(masonryRow.length > 0){
		let js = document.createElement('script');

		js.src = 'assets/js/masonry.min.js';

		document.body.appendChild(js);

		js.addEventListener('load', function (){
			let childs = masonryRow.children();

			masonryRow.masonry({
				itemSelector: '.masonry-item',
				columnWidth: '.masonry-sizer',
				percentPosition: true 
			});

			scrollEntranceAnimation.verify();

			$('.btn[data-toggle="masonry"]').click(function(){
				let btn 	= $(this)
				let rout 	= btn.data('content');

				$.ajax({
					url : rout,
					beforeSend: function(){
						btn.html('Carregando <i class="fas fa-spinner fa-spin"></i>');
					}
				}).done(function(request){
					let content = '';
					let template = `<div class="col-md-4 col-sm-6 mgb-30 masonry-item appended-after">
						<div class="noticia">
							<div class="thumbnail">
								<img src="{{thumbnail}}" class="img-fluid" alt="{{titulo}}"/>
							</div>
							<div class="noticia-content">
								<div class="data">
									<div class="dia-mes">
										<div class="dia">{{dia}}</div>
										<div class="mess">{{mes}}</div>
									</div>
									<div class="ano">{{ano}}</div>
								</div>
								<div class="noticia-body">
									<div class="autor-pub">
										<div class="autor"><em>por</em> <strong>{{autor}}</strong></div>
										<div class="publ"><em>Postado em:</em> {{publicado}}</div>
									</div>
									<div class="titulo">{{titulo}}</div>
									<div class="divider"></div>
									<div class="content">{{conteudo}}</div>
									<div class="text-center">
										<a href="{{href}}" class="btn btn-leia-mais">LEIA MAIS</a>
									</div>
								</div>
							</div>
						</div>
					</div>`;

					$(request.noticias).each(function(){
						let noticia = template;

						noticia = noticia.replace(/{{thumbnail}}/g, this.thumbnail);
						noticia = noticia.replace(/{{titulo}}/g, this.titulo);
						noticia = noticia.replace(/{{conteudo}}/g, this.conteudo);
						noticia = noticia.replace(/{{href}}/g, this.href);
						noticia = noticia.replace(/{{dia}}/g, this.dia);
						noticia = noticia.replace(/{{mes}}/g, this.mes);
						noticia = noticia.replace(/{{ano}}/g, this.ano);
						noticia = noticia.replace(/{{autor}}/g, this.autor);
						noticia = noticia.replace(/{{publicado}}/g, this.publicado);

						content += noticia;
					})

					let $content = $(content);

					masonryRow.append($content).masonry('appended', $content);

					scrollEntranceAnimation.verify();

					if(!request.temMaisItens){
						btn.remove();
					}

					btn.html('CARREGAR MAIS');
				})
			});

		})
	}
})();

$('#app iframe').each(function(){
	let parent 	= $(this).parents('.embed-responsive');
	let width 	= $(this).width();
	let height 	= $(this).height();
	let scale 	= (height / width) *100;

	if(parent.length ==0){
		$(this).wrapAll('<div class="embed-responsive" style="padding-bottom:'+scale+'%"></div>')
	}
});

$('#carousel-album').on('slid.bs.carousel', function(){
	let active 		= $(this).find('.carousel-item.active');
	let index 		= active.index();
	let indicators 	= $(this).find('.carousel-indicators');
	let activeIndi	= indicators.find('.active');

	let left = (106 * index) + 3;

	indicators.animate({
		scrollLeft: left
	},100)

});

$('[data-toggle="album"]').click(function(e){
	let target = $(this).data('target');

	e.preventDefault();

	$(target).addClass('show');
	$('body, html').addClass('lock-scroll');
});

$('[data-toggle="close-album"]').click(function(){
	let parent = $(this).parents('.album');

	parent.fadeOut('fast', function(){
		$(this).removeClass('show').removeAttr('style');
		parent.find('.carousel').carousel(0);
		$('body, html').removeClass('lock-scroll');
	});

});

$('#carousel-empresa').on('slid.bs.carousel', function(){
	let active 		= $(this).find('.carousel-item.active');
	let index 		= active.index();
	let indicators 	= $(this).find('.carousel-indicators');
	let activeIndi	= indicators.find('.active');

	let indicator = indicators.find('.active');
	let width = parseInt(indicator.css('width'));

	let left = (width * index) + (index > 0 ? 15 : 0);

	// let left = (indicator * index) + 15;

	indicators.animate({
		scrollLeft: left
	},100)

});