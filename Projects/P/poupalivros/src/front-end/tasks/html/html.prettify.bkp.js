const { src, dest } = require('gulp');
const { html } 		= require('../../tasks.conf');
const prettify 		= require('gulp-prettify');

module.exports = () => {
	src(html.src)
		.pipe(prettify({
			indent_size: 4
		}))
		.pipe(dest(html.dist))
}
