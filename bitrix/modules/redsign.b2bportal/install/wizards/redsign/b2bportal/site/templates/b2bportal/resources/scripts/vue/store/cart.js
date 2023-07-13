
export default {
	namespaced: true,

	state: {
		status: 'pending',
		totalPrice: '',
		totalPriceRaw: 0,
		numProducts: 0,
		addedIds: new Set([]),
		quantityByIds: {},
		...window.__INITIAL_STATE__.cart || {}
	},

	mutations: {
		ADD_ITEM_TO_CART(state, { itemId, quantity })
		{
			state.addedIds.add(itemId);
			Vue.set(state, 'addedIds', new Set([...state.addedIds]));

			if (state.quantityByIds[itemId])
			{
				state.quantityByIds[itemId] += quantity;
			}
			else
			{
				Vue.set(state.quantityByIds, itemId, quantity);
			} 
		}, 

		SET_QUANTITY(state, { itemId, quantity })
		{
			if (quantity > 0)
			{
				state.addedIds.add(itemId);
			}
			else
			{
				state.addedIds.delete(itemId);
			}

			Vue.set(state.quantityByIds, itemId, quantity);
		},

		REMOVE_ITEM_FROM_CART(state, { itemId })
		{
			state.addedIds.delete(itemId);
			Vue.set(state, 'addedIds', new Set([...state.addedIds]));
			Vue.set(state.quantityByIds, itemId, 0);
		},

		UPDATE_STATE(state, payload)
		{
			Vue.set(state, 'totalPrice', payload.totalPrice || 0);
			Vue.set(state, 'totalPriceRaw', payload.totalPriceRaw || '');
			Vue.set(state, 'numProducts', payload.numProducts || 0);
			Vue.set(state, 'addedIds', new Set(payload.addedIds || []));
			Vue.set(state, 'quantityByIds', payload.quantityByIds || {});
		},

		UPDATE_STATUS(state, status)
		{
			state.status = status;
		}
	},

	actions: {
		initialize({ commit }, state = {})
		{
			commit('UPDATE_STATE', state);
		},
		async fetch({ commit }) {
			try
			{
				commit('UPDATE_STATUS', 'fetching')
				const result = await BX.ajax.runAction('redsign:b2bportal.api.cart.fetch');
				if (result.data)
				{
					commit('UPDATE_STATE', result.data);
					commit('UPDATE_STATUS', 'success');
				}
			}
			catch(e)
			{
				console.error(e);
				commit('UPDATE_STATUS', 'error');
			}
		},
		async addItemToCart({ dispatch }, { productId, quantity })
		{
			const data = {};
			data.productId = productId;

			if (quantity)
				data.quantity = quantity;

			try
			{
				const result = await BX.ajax.runAction('redsign:b2bportal.api.cart.add', { data })
				dispatch('fetch');
				return result;
			}
			catch(e)
			{
				console.error(e);
				if (e.errors[0].message)
				{
					toastr.error(e.errors[0].message);
				}
			}
		},
		async addFewItemsToCart({ dispatch }, products)
		{
			const data = { products };
			try
			{
				const result = await BX.ajax.runAction('redsign:b2bportal.api.cart.addMultiple', { data });
				dispatch('fetch');
				return result;
			}
			catch(e)
			{
				console.error(e);
				if (e.errors[0].message)
				{
					toastr.error(e.errors[0].message);
				}
			}
		}
	}
}