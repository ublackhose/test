export function getProductName(row, product)
{
	return typeof(product.name) == 'string' && product.name.length > 0 ? product.name : row.name;
}

export function getVendorCode(row, product)
{
	return [product.vendorCode, row.vendorCode].find(code => code && code !== '');
}

export function checkQuantityRange(range, quantity)
{
	return (
		parseFloat(quantity) >= parseFloat(range.sort_from) &&
		(
			range.sort_to === 'INF' ||
			parseFloat(quantity) <= parseFloat(range.sort_to)
		)
	);	
}