module.exports = [
	{
		input: './src/component.js', 
		output: './js/component.js',
		namespace: 'B2BPortal.SaleOrderDetail',

		adjustConfigPhp: false,
	},
	{
		input: './src/payment.js', 
		output: './js/payment.js',
		namespace: 'B2BPortal.SaleOrderDetail',

		adjustConfigPhp: false,
	}
];
