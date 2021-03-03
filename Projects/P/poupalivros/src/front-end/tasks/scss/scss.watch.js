const { watch } 	= require('gulp');
const { scss }		= require('../../tasks.conf');
const compiler		= require('./scss');

module.exports = () => {
	watch(scss.watch).on('all', (status, file) => {
		compiler();
	});
}
