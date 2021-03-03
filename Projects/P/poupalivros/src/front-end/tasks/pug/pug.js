const { src, dest}  = require('gulp');
const { pug }       = require('../../tasks.conf');
const pugCompiler 	= require('gulp-pug');

module.exports = (data) => {
	let file = data || pug.src;
	let task = src(file)
		.pipe(pugCompiler());

	task.pipe(dest(pug.dist));
}
