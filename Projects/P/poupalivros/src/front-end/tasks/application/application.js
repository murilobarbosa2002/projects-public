const { src, dest , series} 	= require('gulp');
const fs 				= require('fs');
const rename 			= require('gulp-rename');
const resizer			= require('gulp-images-resizer');
const { application }	= require('../../tasks.conf');

module.exports 			= series(icons,manifest);

function icons (done) {
	const sizes = [72, 96,128,144,152,192,384, 512];

	sizes.forEach(size => {
		src(application.src)
			.pipe(resizer({
				width 	: size,
				height  : size
			}))
			.pipe(rename({
				suffix : `-${size}x${size}`
			}))
			.pipe(dest(application.dist));
	});

	done();
}

function manifest (done) {
	var fileContent = jsonFile(application);

	fs.writeFile(`${application.dist}/manifest.json`, fileContent , err => {
		if(err) return err;

		console.log('Arquivo manifest.json criado com sucesso!');
	});

	console.log(`${application.dist}/manifest.json`)

	done();
}

function jsonFile (config) {
	return JSON.stringify({
		"name" 				: config.name,
		"short_name" 		: config.short_name || config.name,
		"theme_color" 		: config.themeColor,
		"background_color" 	: config.themeColor,
		"display" 			: "standalone",
		"Scope" 			: "/",
		"start_url" 		: "/",
		"icons" 			: [
		{
			"src" 	: "icon-72x72.png",
			"sizes" : "72x72",
			"type" 	: "image/png"
		},
		{
			"src" 	: "icon-96x96.png",
			"sizes" : "96x96",
			"type" 	: "image/png"
		},
		{
			"src" 	: "icon-128x128.png",
			"sizes" : "128x128",
			"type" 	: "image/png"
		},
		{
			"src" 	: "icon-144x144.png",
			"sizes" : "144x144",
			"type" 	: "image/png"
		},
		{
			"src" 	: "icon-152x152.png",
			"sizes" : "152x152",
			"type" 	: "image/png"
		},
		{
			"src" 	: "icon-192x192.png",
			"sizes" : "192x192",
			"type" 	: "image/png"
		},
		{
			"src" 	: "icon-384x384.png",
			"sizes" : "384x384",
			"type" 	: "image/png"
		},
		{
			"src" 	: "icon-512x512.png",
			"sizes" : "512x512",
			"type" 	: "image/png"
		}
		],
		"splash_pages" : null
	}, undefined, 4);
}
