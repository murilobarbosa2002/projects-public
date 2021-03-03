const {
	src,
	dest,
	series,
	watch
} = require('gulp');

const {fonts}  = require('../tasks.config.js');
const {reload} = require('./server.js');

exports.start   = FONTS_START;
exports.default = FONTS;
exports.watch   = FONTS_WATCH;

function FONTS_WATCH(done) {
	watch(fonts.src, series(
		FONTS,
		reload
	));

	done();
}

function FONTS_START(done) {
	copy(fonts.copy);

	done();
}

function FONTS(done) {
	copy(fonts.src);

	done();
}

function copy(files) {
	src(files)
		.pipe(dest(fonts.dist));
}