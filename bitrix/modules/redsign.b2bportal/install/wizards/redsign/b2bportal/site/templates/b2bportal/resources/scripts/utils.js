export const getRelativeQuantity = (quantity, factor, mess = {}) => (
	quantity > factor ? 
		mess['RELATIVE_QUANTITY_MANY'] :
		(
			quantity > 0 && quantity <= factor ?
				mess['RELATIVE_QUANTITY_FEW'] :
				mess['RELATIVE_QUANTITY_NO']
		)
);

export function isPositionStickySupported() 
{
    const prefix = ['', '-o-', '-webkit-', '-moz-', '-ms-']
    const test = document.head.style

    for (let i = 0; i < prefix.length; i += 1) {
        test.position = `${prefix[i]}sticky`
    }

    return test.position === 'sticky' ? true : false;
}