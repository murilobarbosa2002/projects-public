const { watch } 	= require('gulp');
const { imagens }   = require('../../tasks.conf');
const imagemin      = require('./imagemin');
const webp			= require('./webp');

module.exports = () => {
    watch(imagens.watch).on('all', (status, file) => {
        console.log(`${status} file ${file}`);

        let path 			= file.split('/images/')[1];
        let destinePath 	= path.split('/');
        let fileExtendion 	= destinePath[0].split('.')[1];

        let dest 			= imagens.dist;

        if(destinePath.length > 1) {
        	dest 			= `${imagens.dist}/${destinePath[0]}`;
        	fileExtendion 	= destinePath[1].split('.')[1];
        }

        imagemin(file, dest);

        if(fileExtendion == 'jpg' || fileExtendion == 'png') {
        	console.log(`Compiling WEBP format...`);

        	webp(file, dest);
        }
    });
};
