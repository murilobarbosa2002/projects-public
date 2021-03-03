const gulp 				= require('gulp');
const gulpChanged 		= require('gulp-changed');
const config 			= require('../../tasks.config.js');

module.exports = () => {
	gulp.src(config.fonts.src)
		.pipe(gulpChanged(config.fonts.dist))
		.pipe(gulp.dest(config.fonts.dist))
}