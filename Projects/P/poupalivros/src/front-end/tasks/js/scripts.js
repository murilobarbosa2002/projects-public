const { src, dest } = require('gulp');
const { js } 		= require('../../tasks.conf');
const babel	 		= require('gulp-babel');
const sourcemaps 	= require('gulp-sourcemaps');
const concate 		= require('gulp-concat');

module.exports = () => {
	src(js.src)
		.pipe(sourcemaps.init())
		.pipe(concate('scripts.min.js'))
		.pipe(babel())
		.pipe(sourcemaps.write('./'))
		.pipe(dest(js.dist))
}
