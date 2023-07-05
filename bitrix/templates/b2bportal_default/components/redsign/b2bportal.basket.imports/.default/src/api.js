export async function action(actionName, data)
{
	var resultData = undefined;

	try
	{
		const result = await new Promise((resolve, reject) => {
			BX.ajax.runComponentAction(
				'redsign:b2bportal.basket.imports',
				actionName,
				{
					mode: 'class',
					data: data,
				}
			).then(resolve, reject);
		});

		resultData = result.data;
	}
	catch (e)
	{
		global.toastr.error(((e.errors || [])[0] || {}).message);
		throw e;
	}

	return resultData;
};

export async function checkExistsCodes(data)
{
	return action('check', data);
}

export async function addtobasket(data)
{
	return action('addtobasket', data)
		.then((result) => {
			BX.onCustomEvent('updateBasketComponent');

			return result;
		});
}


export async function parseFile(data)
{
	return action('parseFile', data);
}