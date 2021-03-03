const {
	src,
	dest,
	series,
	watch
} = require('gulp');

const babel 		= require('gulp-babel');
const sourcemaps 	= require('gulp-sourcemaps');
const uglify		= require('gulp-uglify');
const concat 		= require('gulp-concat');
const rename 		= require('gulp-rename');

const {js} 		= require('../tasks.config.js');
const {reload} 	= require('./server.js');

exports.default = JS;
exports.watch   = JS_WATCH;

function JS_WATCH (done) {
	watch(js.watch, series(
		JS,
		reload
	));

	done();
}

function JS(done) {
	let FILE = src(js.src)
		.pipe(sourcemaps.init())
		.pipe(concat(js.concat))
		.pipe(babel());

	if(js.minify) {
		let MINIFIED = FILE;

		MINIFIED.pipe(rename({
			suffix: '.min'
		}))
		.pipe(uglify())
		.pipe(sourcemaps.write('./'))
		.pipe(dest(js.dist));
	}

	FILE.pipe(sourcemaps.write('./'))
		.pipe(dest(js.dist));

	done();
}