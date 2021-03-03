const {
	src,
	dest,
	series,
	watch
} = require('gulp');

const {json} 	= require('../tasks.config.js');
const {reload} 	= require('./server.js');

exports.default = Json;
exports.watch 	= Json_WATCH;

function Json(done) {
	hasJson(done);

	src(json.src)
		.pipe(dest(json.dist))

	done();
}

function Json_WATCH(done) {
	hasJson(done);

	watch(json.src, series(
		Json,
		reload
	));

	done();
}

function hasJson(done) {
	if(!json) {
		console.log(`
			Você não tem arquivos JSON, considere remover esta tarefa.
		`)
		return false;
	}

	else if(!json.src) {
		console.log(`
		Prop [src] está vazia ou não existe
		`)
		return false;
	}
}