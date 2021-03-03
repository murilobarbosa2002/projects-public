const gulp 			= require('gulp');
const sass 			= require('gulp-sass');
const autoprefixer 	= require('gulp-autoprefixer');
const config 		= require('../../tasks.config.js');
const sourcemaps   	= require('gulp-sourcemaps');

module.exports = (connect)=>{
	gulp.src(config.sass.src)
		.pipe(sourcemaps.init())
		.pipe(sass())
		.pipe(autoprefixer({
			browsers: ['last 4 versions', '> 1%', 'ie 8','ie 7'],
			cascade: false
		}))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(config.sass.dist))
}