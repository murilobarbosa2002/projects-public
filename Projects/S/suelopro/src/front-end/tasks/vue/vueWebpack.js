const gulp 			= require('gulp');
const config 		= require('../../tasks.config.js');
const webpackStream = require('webpack-stream');
const configWebpack = require('../../webpack.config.js');

module.exports = (processo)=> {
	return ()=> {
		gulp.src(config.vue.src)
			.pipe(webpackStream(configWebpack(processo)))
			.pipe(gulp.dest(config.vue.dist));
	}
}