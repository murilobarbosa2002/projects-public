const {
	src,
	dest,
	watch,
	series
} = require('gulp');

const {jade} 	= require('../tasks.config.js');
const {reload} 	= require('./server.js');
const compiler 	= require('gulp-jade');
const prettify 	= require('gulp-prettify');

exports.default = JADE;
exports.watch   = JADE_WATCH;

function JADE (done) {
	src(jade.src)
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
		.pipe(dest(jade.dist));

	done();
}

function JADE_WATCH (done) {
	watch(jade.watch, series(
		JADE,
		reload
	))

	done();
}