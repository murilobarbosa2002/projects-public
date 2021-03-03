module.exports = {
	application : {
		name	   : 'Nome do Projeto',
		short_name : 'Nome do Projeto',
		themeColor : '#bd1e33',
		src 	   : 'src/assets/application/*.png',
		dist 	   : 'dist/assets/application'
	},
	pug : {
		src   : 'src/pug/*.pug',
		watch : 'src/pug/**/**/**/*.pug',
		dist  : 'dist'
	},
	html : {
		src 	: 'dist/*.html',
		dist 	: 'dist/'
	},
	fonts : {
		src : 'src/assets/fonts/**/*.{eot,svg,ttf,woff,woff2}',
		dist: 'dist/assets/fonts'
	},
	imagens : {
		src  	: 'src/assets/images/**/*.{png,svg,ico,jpg}',
		dist 	: 'dist/assets/images',
		watch 	: 'src/assets/images/**/*.{png,svg,ico,jpg}',
		webp    : {
			src 	: 'src/assets/images/*.{png,jpg}',
			dist 	: 'dist/assets/images/'
		}
	},
	js : {
		src : 'src/assets/js/*.js',
		dist: 'dist/assets/js',
	},
	uglify : {
		src : 'dist/assets/js/scripts.min.js',
		dist: 'dist/assets/js'
	},
	sprites : {
		png : {
			src 	: 'src/assets/sprites/png/*.png',
			dist 	: {
				css : 'src/assets/scss/components',
				img : 'dist/assets/images'
			}
		},
		svg : {
			src : 'src/assets/sprites/svg/*.svg',
			dist: 'src/pug/components/'
		}
	},
	scss : {
		src   : 'src/assets/scss/estilos.scss',
		watch : 'src/assets/scss/**/**/*.scss',
		dist  : 'dist/assets/css'
	},
	copyAll : {
		jquery : {
			js : {
				src : 'node_modules/jquery/dist/jquery.min.js',
				dist: 'dist/assets/js/'
			},
			map : {
				src : 'node_modules/jquery/dist/jquery.min.map',
				dist: 'dist/assets/js'
			}
		},
		bootstrap : {
			js : {
				src    : 'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
				dist   : 'dist/assets/js',
				rename : 'bootstrap.min.js'
			}
		},
		fontAwesome : {
			fonts : {
				src : 'node_modules/@fortawesome/fontawesome-free/webfonts/*',
				dist: 'dist/assets/webfonts/'
			},
			css : {
				src : 'node_modules/@fortawesome/fontawesome-free/css/all.css',
				dist: 'src/assets/scss/vendors/',
				rename: '_font-awesome.scss'
			},
			variaveis: {
				src : 'node_modules/@fortawesome/fontawesome-free/scss/_variables.scss',
				dist: 'src/assets/scss/vendors/',
				rename: '_font-awesome-variaveis.scss'
			}
		},
		owlCarousel : {
			js : {
				src : 'node_modules/owl.carousel2/dist/owl.carousel.min.js',
				dist: 'dist/assets/js/'
			},
			css: {
				src: 'node_modules/owl.carousel2/dist/assets/owl.carousel.min.css',
				dist: 'dist/assets/css/'
			}
		},
		animateCSS : {
			css : {
				src    : 'node_modules/animate.css/animate.css',
				dist   : 'src/assets/scss/vendors/',
				rename : '_animate-css.scss'
			}
		},
		lightBox : {
			css : {
				src : 'node_modules/lightbox2/dist/css/lightbox.min.css',
				dist: 'dist/assets/css/'
			},
			imgs : {
				src : 'node_modules/lightbox2/dist/images/*',
				dist: 'dist/assets/images/'
			},
			js : {
				src: 'node_modules/lightbox2/dist/js/lightbox.min.js',
				dist: 'dist/assets/js/'
			},
			jsMAP : {
				src: 'node_modules/lightbox2/dist/js/lightbox.min.map',
				dist: 'dist/assets/js/'
			}
		}
	}
}
