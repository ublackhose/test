export function sendRequest(data)
{
	data.via_ajax = true;
	data.sessid = BX.sessid_id();
}

export function updateQuantity(params)
{
	const requestData = {
		signedParameters: params.signedParameters,
		site_id: params.siteId,
		basket: {}
	};

	if (params.values)
	{
		for (let itemId in params.values)
		{
			requestData.basket['QUANTITY_'.itemId] = params.values[itemId];
		}

		return sendRequest(requestData);
	}

	return {};
}