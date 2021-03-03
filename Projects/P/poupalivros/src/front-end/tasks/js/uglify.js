const { src , dest } 	= require('gulp');
const { uglify }		= require('../../tasks.conf');
const uglifyer			= require('gulp-uglify');

module.exports = () => {
	src(uglify.src)
		.pipe(uglifyer())
		.pipe(dest(uglify.dist));
}
