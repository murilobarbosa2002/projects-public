const gulp 		= require('gulp');
const config 	= require('../../tasks.config.js');

module.exports = () =>{
	gulp.src(config.json.src)
		.pipe(gulp.dest(config.json.dist));
}