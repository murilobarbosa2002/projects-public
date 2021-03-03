const gulp 		= require('gulp');
const prettify 	= require('./html-formater/index');

const fs 		= require('fs');
const path 		= require('path');

function fromDir(startPath,filter,callback){

    //console.log('Starting from dir '+startPath+'/');

    if (!fs.existsSync(startPath)){
        console.log("no dir ",startPath);
        return;
    }

    var files=fs.readdirSync(startPath);
    for(var i=0;i<files.length;i++){
        var filename=path.join(startPath,files[i]);
        var stat = fs.lstatSync(filename);
        if (stat.isDirectory()){
            fromDir(filename,filter,callback); //recurse
        }
        else if (filter.test(filename)) callback(filename);
    };
};


module.exports = () =>{
	let files = [];

	fromDir('./dist',/\.html$/,function(filename){

	    files.push(`./${filename}`);

	});

	files.forEach(file => {
		fs.readFile(file, function(err, data) {
			if(err) return err;

			let html = data.toString('utf-8');
			let novoHtml = prettify.render(html)

			fs.writeFile(file, novoHtml, function(err){
				if(err) return err;
			})
		});
	})

	console.log('Uhul!...\nTodos os arquivos HTML foram indentados! ;)')

}
