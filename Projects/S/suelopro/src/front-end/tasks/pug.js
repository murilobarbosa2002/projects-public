const {
	src,
	dest,
	watch,
	series
} = require('gulp');

const {pug} 	= require('../tasks.config.js');
const {reload} 	= require('./server.js');
const compiler 	= require('gulp-pug');
const prettify 	= require('gulp-prettify')

exports.default = PUG;
exports.watch 	= PUG_WATCH;

function PUG (done) {
	src(pug.src)
		.pipe(compiler())
		.pipe(prettify({
			"indent_size": 4,
			"indent_with_tabs": true,
			"inline": [
				"abbr",
				"area",
				"b",
				"bdi",
				"bdo",
				"br",
				"cite",
				"code",
				"data",
				"datalist",
				"del",
				"dfn",
				"em",
				"embed",
				"i",
				// "img",
				"ins",
				"kbd",
				"keygen",
				"map",
				"mark",
				"math",
				"meter",
				"object",
				"progress",
				"q",
				"ruby",
				"s",
				"samp",
				"small",
				"span",
				"strong",
				"style",
				"sub",
				"sup",
				"time",
				"u",
				"var",
				"wbr",
				"text",
				"acronym",
				"big",
				"dt",
				"ins",
				"strike",
				"tt"
			]
		}))
		.pipe(dest(pug.dist));

	done();
}

function PUG_WATCH (done) {
	watch(pug.watch, series(
		PUG,
		reload
	))

	done();
}