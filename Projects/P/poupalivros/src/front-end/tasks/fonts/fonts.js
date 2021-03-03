const { src , dest } 	= require('gulp');
const { fonts }			= require('../../tasks.conf');

module.exports = (input, output) => {
	let file 	= input || fonts.src;
	let destine = output || fonts.dist;

	src(file)
		.pipe(dest(destine));
}
