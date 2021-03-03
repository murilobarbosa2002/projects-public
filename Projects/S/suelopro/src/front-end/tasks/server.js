const browserSync 	= require('browser-sync').create();
const compress 		= require('compression');

exports.default =  SERVER;
exports.reload 	=  reload;
exports.stream 	=  browserSync.stream;

function SERVER(done) {
	browserSync.init({
        server 	: ['./dist'],
        port 	: 9000,
        open 	: false,
        notify 	: false,
        middleware: [
        	compress()
        ]
    });

    done();
}

function reload(done) {
	browserSync.reload();

	done();
}