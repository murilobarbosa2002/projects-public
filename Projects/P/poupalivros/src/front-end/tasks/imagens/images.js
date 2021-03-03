const gulp 		= require('gulp');
const imgmin 	= require('./imagemin');
const webp		= require('./webp');

module.exports = () => {
	imgmin();

	webp();
}
