const gulp 		= require('gulp');
const rename 	= require('gulp-rename');
const conf 		= require('../../tasks.config.js');

module.exports = () =>{
	var vendors = conf.vendorsCopy;

	for(let lb in vendors){
		let library = vendors[lb];

		for(let f in library){

			var task = gulp.src(library[f].src);
					

			if(library[f].rename){
				task.pipe(rename(library[f].rename))
				.pipe(gulp.dest(library[f].dist))

			}else{
				task.pipe(gulp.dest(library[f].dist));
			}

		}
	}
}