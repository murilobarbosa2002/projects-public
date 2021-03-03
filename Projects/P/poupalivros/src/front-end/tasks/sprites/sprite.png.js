const { src, dest } = require('gulp');
const { sprites } 	= require('../../tasks.conf');
const spritesmith	= require('gulp.spritesmith');
const template 		= require('./template.scss.handlebars');

module.exports = () => {
	let spriter = src(sprites.png.src)
		.pipe(spritesmith({
			imgName 	: 'sprites.png',
			imgPath 	: '../images/sprites.png',
			cssName 	: '_sprites.scss',
			padding 	: 10,
			cssTemplate : template
		}));

	spriter.img.pipe(dest(sprites.png.dist.img));
	spriter.css.pipe(dest(sprites.png.dist.css));
}
