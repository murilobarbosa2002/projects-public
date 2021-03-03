const gulp 			= require('gulp');
const babel 		= require('gulp-babel');
const concat 		= require('gulp-concat');
const config 		= require('../../tasks.config.js');
const sourcemaps   	= require('gulp-sourcemaps');

module.exports = () => {
	gulp.src(config.js.src)
		.pipe(sourcemaps.init())
		.pipe(concat('scripts.js'))
		.pipe(babel({
			presets: ['env']
		}))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(config.js.dist))
}