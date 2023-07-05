const commonjs  = require('rollup-plugin-commonjs');
const vue = require('rollup-plugin-vue');

module.exports = [
	{
		input: './src/CodesImport.js',
		output: './js/CodesImport.js',
		namespace: 'B2BPortal.Components',

		adjustConfigPhp: false,

		plugins: {
			resolve: true,

			custom: [
				commonjs({ sourceMap: false }),
				vue({ needMap: false })
			],
		}
	},
	{
		input: './src/FileImport.js',
		output: './js/FileImport.js',
		namespace: 'B2BPortal.Components',

		adjustConfigPhp: false,

		plugins: {
			resolve: true,
			
			custom: [
				commonjs({ sourceMap: false }),
				vue({ needMap: false })
			],
		}
	}
];