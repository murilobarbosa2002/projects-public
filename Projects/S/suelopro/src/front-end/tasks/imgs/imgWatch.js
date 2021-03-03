const gulp 				= require('gulp');
const imagemin 			= require('gulp-imagemin');
const config 			= require('../../tasks.config.js');


module.exports = (file)=>{
	var path = file.path.split('/src');
	var currentFile = 'src'+path[1];

	gulp.src(currentFile)
		.pipe(imagemin([
			imagemin.gifsicle({interlaced: true}),
			imagemin.jpegtran({progressive: true}),
			imagemin.optipng({optimizationLevel: 5}),
			imagemin.svgo({
		        plugins: [
					{optimizationLevel: 3 },
					{progessive: true },
					{interlaced: true },
					{removeViewBox: false},
					{removeUselessStrokeAndFill: false },
					{cleanupIDs: false}
		        ]
	      	})
	    ]))
	    .pipe(gulp.dest(config.imgs.dist))
}