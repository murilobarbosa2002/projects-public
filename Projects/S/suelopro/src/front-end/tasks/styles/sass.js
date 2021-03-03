const gulp 			= require('gulp');
const sass 			= require('gulp-sass');
const autoprefixer 	= require('gulp-autoprefixer');
const config 		= require('../../tasks.config.js');
const sourcemaps   	= require('gulp-sourcemaps');

module.exports = ()=>{
	gulp.src(config.sass.src)
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'compressed'
		}))
		.pipe(autoprefixer({
			browsers: ['last 4 versions', '> 1%', 'ie 8','ie 7'],
			cascade: false
		}))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(config.sass.dist))
}