const {
	src,
	dest,
	watch,
	series
} = require('gulp');

const {webp} 	= require('../tasks.config.js');
const {reload}  = require('./server.js');
const compiler 	= require('gulp-webp');

exports.start 	= WEBP;
exports.default = WEBP;
exports.watch 	= WEBP_WATCH;

function WEBP(done) {
	webp.forEach(img => {
		COMPILE(img);
	});

	done();
}

function WEBP_WATCH (done) {
	webp.forEach(img => {
		let task = function(done) {
			COMPILE(img);

			done();
		}

		watch(img.src, series(
			task,
			reload
		));
	});

	done();
}

function COMPILE (img) {
	src(img.src)
		.pipe(compiler())
		.pipe(dest(img.dist));
}