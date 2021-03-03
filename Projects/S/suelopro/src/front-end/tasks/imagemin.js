const {
	src,
	dest,
	watch,
	series
} = require('gulp');

const {imgs} 	= require('../tasks.config.js');
const {reload}  = require('./server.js');
const imagemin 	= require('gulp-imagemin');

const imageminConfig = [
	imagemin.gifsicle({interlaced: true}),
	imagemin.mozjpeg({quality: 75, progressive: true}),
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
];

exports.start   = IMGS;
exports.default = IMGS;
exports.watch   = IMGS_WATCH;

function IMGS(done) {
	imgs.forEach(img => {
		MINIFY(img);
	});

	done();
}

function MINIFY(img) {
	src(img.src)
		.pipe(imagemin(imageminConfig))
		.pipe(dest(img.dist))
}

function IMGS_WATCH(done) {
	imgs.forEach(img => {
		let task =  function (done) {
			MINIFY(img);

			done();
		}

		watch(img.src, series(
			task,
			reload
		));

	})

	done();
}