const { watch } 		= require('gulp');
const { fonts }			= require('../../tasks.conf');
const fontStalker		= require('./fonts')

module.exports = () => {
	watch(fonts.src).on('all', (status, file) => {
		console.log(`${status} file ${file}`);

		let path = file.split('/fonts/')[1];
        let destinePath = path.split('/')[0];

        fontStalker(file, `${fonts.dist}/${destinePath}`);
	});
}
