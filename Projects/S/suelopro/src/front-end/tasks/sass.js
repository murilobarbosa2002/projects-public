const {
	src,
	dest,
	watch,
	series
} = require('gulp');

const {scss} 		= require('../tasks.config.js');
const {stream} 		= require('./server.js');
const sass 			= require('gulp-sass');
const sourcemaps 	= require('gulp-sourcemaps');
const autoprefixer 	= require('gulp-autoprefixer');
const rename 		= require('gulp-rename');

exports.default = SASS;
exports.watch 	= SASS_WATCH;

function SASS_WATCH (done) {
	watch(scss.watch, SASS);

	done();
}

function SASS (done) {
	let FILE = src(scss.src)
	.pipe(sourcemaps.init())
	
	let MINIFYED = FILE;

	FILE.pipe(sass({
		outputStyle: 'expanded'
	}))
	.pipe(sourcemaps.write('./'))
	.pipe(dest(scss.dist))

	MINIFYED.pipe(sass({
		outputStyle: 'compressed'
	}))
	.pipe(rename({
		suffix: '.min'
	}))
	.pipe(sourcemaps.write('./'))
	.pipe(stream())
	.pipe(dest(scss.dist))

	done();
}