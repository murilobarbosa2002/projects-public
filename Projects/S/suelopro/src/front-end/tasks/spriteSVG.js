const {
	src,
	dest,
	series,
	watch
} = require('gulp');

const {sprites} = require('../tasks.config.js');
const {reload} 	= require('./server.js');
const svgstore	= require('gulp-svgstore');
const rename 	= require('gulp-rename');

const {svg} = sprites;

exports.default = SVG;
exports.watch 	= SVG_WATCH;

function SVG (done){
	src(svg.src)
		.pipe(svgstore())
		.pipe(rename('sprites.svg'))
		.pipe(dest(svg.dist));

	done();
}

function SVG_WATCH (done) {
	watch(svg.src, series(
		SVG,
		reload
	));

	done();
}