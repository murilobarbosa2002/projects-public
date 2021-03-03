const { watch } 	= require('gulp');
const { pug }		= require('../../tasks.conf');
const compiler		= require('./pug');

module.exports 	= () => {
	watch(pug.watch).on('all', (status, file) => {
		let corePath 		= file.split('/pug/')[1];
		let componentPath	= corePath.split('/');

		console.log(`${status} file ${file}`)

		if(componentPath.length > 1) {
			compiler();
		} else{
			compiler(file);
		}
	});
}
