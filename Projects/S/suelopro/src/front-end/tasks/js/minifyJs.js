const gulp 		= require('gulp');
const uglify 	= require('gulp-uglify');
const config 	= require('../../tasks.config.js');

module.exports = () => {
	gulp.src(config.js.build)
		.pipe(uglify())
		.pipe(gulp.dest(config.js.dist))
}