const { watch } 	= require('gulp');
const { sprites } 	= require('../../tasks.conf');
const compiler		= require('./sprite.svg');

module.exports 		= ()  => {
	watch(sprites.svg.src).on('all', (status, file) => {
		console.log(`${status} file ${file}`);
		compiler();
	})
}
