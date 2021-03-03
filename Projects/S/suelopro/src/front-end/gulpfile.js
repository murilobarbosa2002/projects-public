const {
	series,
	parallel
} = require('gulp');

const SERVER 	= require('./tasks/server.js')
const FONTS 	= require('./tasks/fonts.js')
const IMGS 		= require('./tasks/imagemin.js')
const JADE 		= require('./tasks/jade.js')
const JS 		= require('./tasks/javascript.js')
const Json 		= require('./tasks/json.js')
const LIBS 		= require('./tasks/libs.js')
const PUG 		= require('./tasks/pug.js')
const SASS 		= require('./tasks/sass.js')
const SPRITES 	= require('./tasks/sprites.js')

exports['fonts'] 	= FONTS.default
exports['imgs'] 	= IMGS.default
exports['jade']		= JADE.default
exports['js'] 		= JS.default
exports['json'] 	= Json.default
exports['libs'] 	= LIBS.start
exports['pug'] 		= PUG.default
exports['sass'] 	= SASS.default
exports['sprites'] 	= SPRITES.default

exports['start'] = parallel(
	FONTS.default,
	IMGS.default,
	JADE.default,
	JS.default,
	Json.default,
	LIBS.start,
	PUG.default,
	SASS.default,
	SPRITES.default,
)

exports['dev'] = parallel(
	SERVER.default,
	FONTS.watch,
	IMGS.watch,
	JADE.watch,
	JS.watch,
	Json.watch,
	LIBS.watch,
	PUG.watch,
	SASS.watch,
	SPRITES.watch,
)

exports['default'] = series(
	this['start'],
	this['dev']
)