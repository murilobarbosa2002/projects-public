const gulp 				= require('gulp');
const config 			= require('../../tasks.config.js');
const pug 				= require('gulp-pug');
const gulpChanged 		= require('gulp-changed');

module.exports = (connect) => {
	gulp.src(config.pug.src)
		.pipe(gulpChanged(config.pug.dist))
		.pipe(pug({
			pretty: '    '
		}))
		.pipe(gulp.dest(config.pug.dist))
}