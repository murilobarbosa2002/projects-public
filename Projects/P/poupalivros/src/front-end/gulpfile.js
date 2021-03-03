const { task, series, parallel } = require('gulp');

// IMPORTANDO AS TAREFAS
const application 		= require('./tasks/application/application');
const applicationWatch	= require('./tasks/application/application.watch');

const copy 				= require('./tasks/copy/copy');

const fonts				= require('./tasks/fonts/fonts');
const fontsWatch		= require('./tasks/fonts/fonts.watch');

const html				= require('./tasks/html/html.prettify');

const imgs 				= require('./tasks/imagens/images');
const imgsWatch			= require('./tasks/imagens/image.watch');

const js 				= require('./tasks/js/scripts');
const jsWatch 			= require('./tasks/js/scripts.watch');

const pug				= require('./tasks/pug/pug');
const pugWatch			= require('./tasks/pug/pug.watch');

const sass				= require('./tasks/scss/scss');
const sassWatch			= require('./tasks/scss/scss.watch');

const server 			= require('./tasks/server/server');

const spriteSVG 		= require('./tasks/sprites/sprite.svg');
const spriteSVGWatch	= require('./tasks/sprites/sprite.svg.watch');

const spritePNG 		= require('./tasks/sprites/sprite.png');
const spritePNGWatch	= require('./tasks/sprites/sprite.png.watch');

const uglify 			= require('./tasks/js/uglify');

// TASKS
task('app', done => {
	application();
	done();
});

task('app:watch', done => {
	applicationWatch();
	done();
});

task('copy', done => {
	copy();
	done();
});

task('fonts', done => {
	fonts();
	done();
});

task('fonts:watch', done => {
	fontsWatch();
	done();
});

task('html', done => {
	html();
	done();
});

task('uglify', done => {
	uglify();
	done();
});

task('js', done => {
	js();
	done();
});

task('js:watch', done => {
	jsWatch();
	done();
});

task('imgs', done => {
	imgs();
	done();
});

task('imgs:watch', done => {
	imgsWatch();
	done();
});

task('server', done => {
	server();
	done();
});

task('sass', done => {
	sass();
	done();
});

task('sass:watch', done => {
	sassWatch();
	done();
});

task('pug', (done)=> {
	pug();

    done();
});

task('pug:watch', (done)=> {
	pugWatch();

    done();
});

task('sprite:png', (done)=> {
	spritePNG();

    done();
});

task('sprite:pngWatch', (done)=> {
	spritePNGWatch();

    done();
});

task('sprite:svg', (done)=> {
    spriteSVG();

    done();
});

task('sprite:svgWatch', (done)=> {
    spriteSVGWatch();

    done();
});

task('start', series(
	'copy',
	'sprite:svg',
	'sprite:png',
	'pug',
	'fonts',
	'sass',
	'imgs',
	'js',
	'app'
));

task('dev', parallel(
	'fonts:watch',
	'imgs:watch',
	'js:watch',
	'pug:watch',
	'sprite:pngWatch',
	'sprite:svgWatch',
	'app:watch',
	'server'
));

task('build', series(
	'html',
	'uglify'
));
