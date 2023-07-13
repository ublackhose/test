const commonjs  = require('rollup-plugin-commonjs');
const vue = require('rollup-plugin-vue');

module.exports = {
	input: './src/component.js', 
	output: {
		js: './script.js',
		css: './style.css'
	},
	adjustConfigPhp: false,
	plugins: {
		resolve: true,
		custom: [
			commonjs({ sourceMap: false }),
			vue({ needMap: false })
		],
	}
};
