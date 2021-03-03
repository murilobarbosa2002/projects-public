const path 		= require('path');
const webpack 	= require('webpack');
const config 	= require('./tasks.config.js');

module.exports = (processo) => {
	let configWebpack = {
		entry : './src/assets/vue/main.js',
		output: {
			path: path.resolve(__dirname, './dist/assets/js'),
			publicPath: '/dist/',
			filename: 'vue.components.js'
		},
		module: {
			rules : [
				{
					test: /\.css$/,
					use: [
					  	'vue-style-loader',
					  	'css-loader'
					],
				},
				{
					test: /\.scss$/,
					use: [
				  		'vue-style-loader',
				  		'css-loader',
				  		'sass-loader'
					],
				},
				{
					test: /\.sass$/,
					use: [
						'vue-style-loader',
						'css-loader',
						'sass-loader?indentedSyntax'
					],
				},
				{
					test: /\.vue$/,
					loader: 'vue-loader',
					options: {
				  		loaders: {
						    // Since sass-loader (weirdly) has SCSS as its default parse mode, we map
						    // the "scss" and "sass" values for the lang attribute to the right configs here.
						    // other preprocessors should work out of the box, no loader config like this necessary.
						    'scss': [
						      	'vue-style-loader',
						      	'css-loader',
						      	'sass-loader'
						    ],
						    'sass': [
						      	'vue-style-loader',
						      	'css-loader',
						      	'sass-loader?indentedSyntax'
						    ]
				  		}
				  	// other vue-loader options go here
					}
				},
				{
					test: /\.js$/,
					loader: 'babel-loader',
					exclude: /node_modules/
				},
				{
					test: /\.(png|jpg|gif|svg)$/,
					loader: 'file-loader',
					options: {
				  		name: '[name].[ext]?[hash]'
					}
				}
			]
		}, /* }module*/
		resolve : {
			alias: {
				'vue$': 'vue/dist/vue.esm.js'
			},
			extensions: ['*', '.js', '.vue', '.json']
		},
		devtool: '#eval-source-map',
		performance: {
			hints: false
		}
	};

	if(processo == 'dev'){
		configWebpack.watch = true;
	}

	else {
		configWebpack.watch = false;
		
		configWebpack.devtool = '#source-map';
		
		configWebpack.plugins = (configWebpack.plugins || []).concat([
			new webpack.DefinePlugin({
				'process.env': {
					NODE_ENV: '"production"'
				}
			}),
			new webpack.optimize.UglifyJsPlugin({
				sourceMap: true,
				compress: {
					warnings: false
				}
			}),
			new webpack.LoaderOptionsPlugin({
				minimize: true
			})
		])
	}

	return configWebpack;
}