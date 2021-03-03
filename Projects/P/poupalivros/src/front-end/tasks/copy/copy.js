const { src, dest } = require('gulp');
const { copyAll } 	= require('../../tasks.conf');
const rename 		= require('gulp-rename');

module.exports = () => {
	for(let lb in copyAll) {
		let library = copyAll[lb];

		for (let f in library) {
			let file = library[f];
			let task = src(file.src);

			if(file.rename) {
				task.pipe(rename(file.rename))
					.pipe(dest(file.dist));
			}else{
				task.pipe(dest(file.dist));
			}
		}
	}

	console.log('Copiado todos os vendors para seus respectivos lugares.');
}
