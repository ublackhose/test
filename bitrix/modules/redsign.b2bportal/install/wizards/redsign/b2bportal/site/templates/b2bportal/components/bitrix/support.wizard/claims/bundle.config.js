const commonjs  = require('rollup-plugin-commonjs');
const vue = require('rollup-plugin-vue');

module.exports = {
	input: './src/OrderSuggestions.js', 
	output: './js/OrderSuggestions.js',
	namespace: 'B2BPortal.Components',

	adjustConfigPhp: false,

	plugins: {
		resolve: true,
		
		custom: [
			commonjs({ sourceMap: false }),
			vue({ needMap: false })
		],
	}
};
