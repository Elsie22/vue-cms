const path = require('path')
const webpack = require('webpack')
const htmlWebpackPlugin = require('html-webpack-plugin')
const VueLoaderPlugin = require('vue-loader/lib/plugin')

const config = {
	entry: path.join(__dirname, './src/main.js'),
	output:{
		path: path.join(__dirname, './dist/'),
		filename: 'bundle.js'
	},
	plugins:[
		//new webpack.HotModuleReplacementPlugin(),
		new htmlWebpackPlugin({
			template: path.join(__dirname, './src/index.html'),
			filename: 'index.html'
		}),
		new VueLoaderPlugin()
	],
	module:{
		rules:[
			{test: /\.css$/, use: ['style-loader','css-loader']},
			{test: /\.less$/, use: ['style-loader','css-loader','less-loader']},
			{test: /\.(jpg|png|jpeg|bmp|gif)$/, use: ['url-loader?limit=1&name=[hash:8]-[name].[ext]']},
			{test: /\.(ttf|eot|svg|woff|woff2)$/, use: 'url-loader' },
			{test: /\.js$/, use: 'babel-loader', exclude: /node_modules/},
			{test: /\.vue$/, use: 'vue-loader'},
		]
	},
	/*resolve:{
		alias:{
			"vue$": "vue/dist/vue.js"
		}
	},*/
}

module.exports = config
