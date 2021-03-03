const gulp = require('gulp');
const conf = require('../../tasks.config.js');

module.exports = ()=>{
	if(conf.webapp.has){
		
		gulp.src(conf.webapp.icons.src)
			.pipe(gulp.dest(conf.webapp.icons.dist));
		
		gulp.src(conf.webapp.manifest.src)
			.pipe(gulp.dest(conf.webapp.manifest.dist));

	}
}