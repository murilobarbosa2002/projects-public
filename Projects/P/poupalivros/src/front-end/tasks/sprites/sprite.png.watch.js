const { watch } 	= require('gulp');
const { sprites } 	= require('../../tasks.conf');
const compiler		= require('./sprite.png');

module.exports 		= ()  => {
	watch(sprites.png.src).on('all', (status, file) => {
		console.log(`${status} file ${file}`);
		compiler();
	})
}
