const gulp 			= require('gulp');
const gulpChanged 	= require('gulp-changed');
const config 		= require('../../tasks.config.js');

module.exports = (connect) =>{
	gulp.src(config.json.src)
		.pipe(gulpChanged(config.json.dist))
		.pipe(gulp.dest(config.json.dist))
}