const gulp 			= require('gulp');
const minifyCss 	= require('gulp-clean-css');
const config 		= require('../../tasks.config.js');

module.exports = ()=>{
	gulp.src(config.css.src)
		.pipe(minifyCss())
		.pipe(gulp.dest(config.css.dist))
}