const { src, dest } = require('gulp');
const { scss }		= require('../../tasks.conf');
const sassCompiler	= require('gulp-dart-sass');
const autoprefixer 	= require('gulp-autoprefixer');
const sourcemaps 	= require('gulp-sourcemaps');

module.exports = () => {
	src(scss.src)
		.pipe(sourcemaps.init())
		.pipe(sassCompiler({
			outputStyle: 'compressed'
		}))
		.pipe(autoprefixer())
		.pipe(sourcemaps.write('./'))
		.pipe(dest(scss.dist));
}
