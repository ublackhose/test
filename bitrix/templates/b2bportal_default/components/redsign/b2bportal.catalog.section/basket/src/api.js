export async function addItemsToBasket(items)
{
	try
	{
		const result = await BX.ajax.runComponentAction(
			'redsign:b2bportal.catalog.section',
			'multipleadd2basket',
			{
				mode: 'class',
				data: {
					items: items,
					params: {
						lid: BX.message('SITE_ID')
					}
				},
			}
		);

		if (result.data.STATUS == 'OK' && result.data.MESSAGE)
		{
			window.toastr.success(result.data.MESSAGE);
		}
		else if (result.data.STATUS == 'ERROR' && result.data.MESSAGE)
		{
			window.toastr.error(result.data.MESSAGE)
		}

		return result;
	}
	catch (e)
	{
		window.toastr.error(BX.message('RS.B2BPORTAL.ADD2BASKET_ERROR'));
		console.error(e);
	}

	return false;
}
