const {
	src,
	dest,
	series,
	watch
} = require('gulp');

const {libs} 	= require('../tasks.config.js');
const {reload} 	= require('./server.js');
const concat 	= require('gulp-concat');
const {copy} 	= libs;

exports.start = series(LIBS_JS, COPY_LIBS);
exports.watch = LIBS_WATCH;

function LIBS_WATCH(done) {
	watch(libs.src, series(
		LIBS_JS,
		reload
	))

	done();
}

function LIBS_JS(done) {
	src(libs.src)
		.pipe(concat('starter.js'))
		.pipe(dest(libs.dist));

	done();
}

function COPY_LIBS(done) {
	copy.forEach(lib => {
		src(lib.src)
			.pipe(dest(lib.dist))
	})

	done();
}