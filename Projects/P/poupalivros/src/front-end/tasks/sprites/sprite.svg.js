const { src , dest } 	= require('gulp');
const { sprites } 		= require('../../tasks.conf');
const svgstore			= require('gulp-svgstore');
const rename 			= require('gulp-rename');
const imagemin 			= require('gulp-imagemin');

module.exports = () => {
	src(sprites.svg.src)
		.pipe(svgstore())
		.pipe(imagemin([
			imagemin.svgo({
				plugins: [
					{ optimizationLevel: 3 },
					{ progessive: true },
					{ interlaced: true },
					{ removeViewBox: false },
					{ removeUselessStrokeAndFill: false },
					{ cleanupIDs: false }
				]
			})
		]))
		.pipe(rename('sprites.pug'))
		.pipe(dest(sprites.svg.dist));
}
