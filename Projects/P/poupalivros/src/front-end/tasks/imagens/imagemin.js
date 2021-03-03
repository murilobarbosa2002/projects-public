const { src, dest } = require('gulp');
const { imagens }	= require('../../tasks.conf');
const imagemin 		= require('gulp-imagemin');

module.exports = (data, destine) => {
	var file = data 	|| imagens.src;
	var dist = destine 	|| imagens.dist;

	src(file)
		.pipe(imagemin([
			imagemin.gifsicle({interlaced: true}),
			imagemin.jpegtran({progressive: true}),
			imagemin.optipng({optimizationLevel: 5}),
			imagemin.svgo({
				plugins: [
					{optimizationLevel: 3},
					{progessive: true},
					{interlaced: true},
					{removeViewBox: false},
					{removeUselessStrokeAndFill: false},
					{cleanupIDs: false}
				]
			})
		]))
		.pipe(dest(dist));
}
