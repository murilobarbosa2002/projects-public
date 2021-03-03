const gulp = require('gulp');
const config = require('../../tasks.config.js');

module.exports = ()=>{
	gulp.src(config.fonts.src)
		.pipe(gulp.dest(config.fonts.dist));
}