const { watch , src , dest}		= require('gulp');
const browserSync 				= require('browser-sync').create();
const sassCompiler				= require('gulp-dart-sass');
const autoprefixer 				= require('gulp-autoprefixer');
const sourcemaps 				= require('gulp-sourcemaps');
const { scss }					= require('../../tasks.conf');

module.exports = () => {
	browserSync.init({
        server 	: ['dist'],
        port 	: 9000,
        open 	: false,
        notify 	: false
    });

    watch('dist/*.html').on('all', browserSync.reload);

    watch(scss.watch).on('all', (status, file) => {
		src(scss.src)
			.pipe(sourcemaps.init())
			.pipe(sassCompiler({
				outputStyle: 'compressed'
			}))
			.pipe(autoprefixer())
			.pipe(sourcemaps.write('./'))
			.pipe(dest(scss.dist))
			.pipe(browserSync.stream());
	});

    watch('dist/assets/js/*.js').on('all', browserSync.reload);

    watch('dist/assets/json/*.json').on('all', browserSync.reload);

    watch('dist/assets/fonts/**/*.{eot,svg,ttf,woff,woff2}').on('all', browserSync.reload);

    watch('dist/assets/application/**/*').on('all', browserSync.reload);

    watch('dist/assets/images/**/*').on('all', browserSync.reload);
}
