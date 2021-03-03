const { watch } 		= require('gulp');
const { application }	= require('../../tasks.conf');
const compiler			= require('./application');

module.exports 			= () => {
	watch(application.src).on('all', (status, file) => {
		console.log(`"${status}" file ${file}`);

		compiler();
	});
}
