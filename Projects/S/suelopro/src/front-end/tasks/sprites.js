const {
	parallel
} = require('gulp');

const PNG = require('./spritePNG.js');
const SVG = require('./spriteSVG.js');

exports.default = parallel(
	PNG.default,
	SVG.default
);

exports.watch = parallel(
	PNG.watch,
	SVG.watch
);