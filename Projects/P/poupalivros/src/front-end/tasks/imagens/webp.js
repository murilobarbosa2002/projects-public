const {src , dest } = require('gulp');
const imgm 			= require('imagemin');
const webp 			= require('gulp-webp');
const { imagens } 	= require('../../tasks.conf.js');

module.exports = (input, output) => {
	var file 	= input || imagens.webp.src;
	var out 	= output || imagens.webp.dest;

	src(file)
		.pipe(webp({
			lossless: true
		}))
		.pipe(dest(imagens.dist));

	console.log('WEBP compiler Done!')
}
