const commonjs  = require('rollup-plugin-commonjs');
const vue = require('rollup-plugin-vue');

module.exports = [
	{
		input: './src/component.js', 
		output: './js/component.js',
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
		input: './src/filter.js', 
		output: './js/filter.js',
		namespace: 'B2BPortal.SupportTickets',

		adjustConfigPhp: false,
	}
];
