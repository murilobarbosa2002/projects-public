const gulp 		= require('gulp');
const config 	= require('../../tasks.config.js');
const pug 		= require('gulp-pug');

module.exports = () => {
	gulp.src(config.pug.src)
		.pipe(pug({
			pretty: '    '
		}))
		.pipe(gulp.dest(config.pug.dist))
}