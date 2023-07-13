export default {

	namespaced: true,

	state: window.__INITIAL_STATE__.stocks || {
		data: {},
		amounts: {}
	},

	mutations: {
		
		ADD_STOCK(state, data)
		{
			Vue.set(state.data, data.id, data);
		},

		SET_PRODUCT_AMOUNT(state, data)
		{
			Vue.set(state.amounts, data.productId, data.amount);
		}

	},

	actions: {

		async getStocksData({ commit })
		{
			try
			{
				const result = await BX.ajax.runAction('redsign:b2bportal.api.catalog.getStocksData');

				if (result.data)
				{ 
					result.data.forEach(data => commit('ADD_STOCK', data));
				}
				else if (result.errors && result.errors.length)
				{	
					toastr.error(result.errors[0].message)
				}
			}
			catch(e)
			{
				console.error(e);

				if (e.errors && e.errors.length)
				{	
					toastr.error(e.errors[0].message)
				}
			}
		},

		async getProductAmounts({state, dispatch, commit}, productId)
		{
			if (!Object.keys(state.data).length)
			{
				await dispatch('getStocksData');
			}

			try
			{
				const result = await BX.ajax.runAction(
					'redsign:b2bportal.api.catalog.getProductsAmount',
					{
						data: {
							productIds: [productId]
						}
					}
				);
	
				if (result.data && result.data[productId])
				{
					commit('SET_PRODUCT_AMOUNT', {
						productId,
						amount: result.data[productId]
					});
				}
			}
			catch(e)
			{
				console.error(e);

				if (e.errors && e.errors.length)
				{	
					toastr.error(e.errors[0].message)
				}
			}
			
		}

	}

}