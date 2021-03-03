const gulp 		= require('gulp');
const config 	= require('../../tasks.config.js');
const prettify 	= require('gulp-prettify');

module.exports = () =>{
	gulp.src(config.html.src)
		.pipe(prettify({
			ident_size: 4
		}))
		.pipe(gulp.dest(config.html.dist))
}