const gulp 			= require('gulp');
const spritesmith 	= require('gulp.spritesmith');
const config		= require('../../tasks.config.js');

module.exports = () =>{
	let spriteData = gulp.src(config.sprites.png.src)
		.pipe(spritesmith({
			imgName: 'sprite.png',
			imgPath: 'imagens/estrutural/sprite.png',
			cssName: '_sprites.scss',
			cssTemplate: config.sprites.png.template,
			padding: 10,
			// retinaSrcFilter : [config.sprites.png.retina],
			// retinaImgName 	: 'sprite@2x.png',
			// retinaImgPath  	: 'imagens/estrutural/sprites@2x.png'
		}));

		spriteData.img.pipe(gulp.dest(config.sprites.png.dist.img));
		spriteData.css.pipe(gulp.dest(config.sprites.png.dist.css));
}