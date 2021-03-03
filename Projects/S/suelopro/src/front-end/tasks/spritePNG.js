const {
	src,
	dest,
	series,
	watch
} = require('gulp');

const {sprites} = require('../tasks.config.js');
const {reload} 	= require('./server.js');

const spritesmith 	= require('gulp.spritesmith');
const template 		= require('./template.scss.handlebars');

const {png} 		= sprites;

exports.default = PNG;
exports.watch  	= PNG_WATCH;

function PNG (done) {
	let spriteDATA = src(png.src)
		.pipe(spritesmith({
			imgName: 'sprite.png',
			imgPath 	: '../images/sprites.png',
			cssName 	: '_sprites.scss',
			padding 	: 10,
			cssTemplate : template
		}));

	spriteDATA.img.pipe(dest(png.img));
	spriteDATA.css.pipe(dest(png.css));

	done();
}

function PNG_WATCH (done) {
	watch(png.src, series(
		PNG,
		reload
	));
}