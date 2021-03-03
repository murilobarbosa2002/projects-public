const paths = {
	src: 'src',
	dist: 'dist'
};

const copy = {
	fonts: [
		'node_modules/font-awesome/fonts/*',
		'src/assets/fonts/**/*'
	]
}

module.exports = {
	fonts: {
		src :'src/assets/fonts/**/*',
		dist: 'dist/assets/fonts/',
		copy: copy.fonts
	},
	imgs: [
		{
			src: 'src/assets/images/*.{png,jpg,svg,ico,gif,webp,jpeg}',
			dist: 'dist/images'
		}
	],
	webp : [
		{
			src :'src/assets/images/*.{png,jpg,gif}',
			dist: 'dist/assets/images' 
		},
	],
	js : {
		src:'src/assets/js/*.js',
		concat: 'scripts.js',
		minify: true,
		dist: 'dist/assets/js',
		watch:'src/assets/js/*.js'
	},
	json : {
		src:'src/assets/json/*.json',
		dist: 'dist/assets/json'
	},
	pug : {
		src:'src/pug/*.pug',
		watch: 'src/pug/**/*.pug',
		dist: 'dist/'
	},
	jade : {
		src:'src/jade/*.jade',
		watch: 'src/jade/**/*.jade',
		dist: 'dist/'
	},
	sprites: {
		png: {
			src :'src/assets/icons/png/*.png',
			img :'src/assets/images',
			css :'src/assets/scss/components/modules'
		},
		svg: {
			src :'src/assets/icons/svg/*.svg',
			dist:'src/assets/images/'
		}
	},
	scss : {
		src:'src/assets/scss/estilos.scss',
		watch:'src/assets/scss/**/**/**/**/**/*.scss',
		dist: 'dist/assets/css' 
	},
	libs: {
		src: [
			'bower_components/jquery/dist/jquery.min.js',
			'bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js',
			'src/libs/*.js'
		],
		concat: 'starter.js',
		dist: 'dist/js/',
		copy: [
			{
				src: [
					'bower_components/lightbox/dist/js/lightbox.min.js',
					'bower_components/lightbox/dist/js/lightbox.min.map'
				],
				dist: 'dist/js'
			}
		]
	}
}
