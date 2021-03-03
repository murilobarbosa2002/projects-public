const gulp 		= require('gulp');
const svgstore	= require('gulp-svgstore');
const rename	= require('gulp-rename');
const config	= require('../../tasks.config.js');

module.exports = () => {
	gulp.src(config.sprites.svg.src)
		.pipe(svgstore())
		.pipe(rename('sprites.svg'))
		.pipe(gulp.dest(config.sprites.svg.dist));
};