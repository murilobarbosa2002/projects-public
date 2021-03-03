const { watch } = require('gulp');
const { js }	= require('../../tasks.conf');
const scripter 	= require('./scripts');

module.exports 	= () => {
	watch(js.src).on('all', (status, file) => {
		console.log(`${status} file ${file}`);

		scripter();
	});
}
