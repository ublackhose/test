const runAction = (actionName, data) => new Promise((resolve, reject) => {
	BX.ajax.runAction(`redsign:vbasket.api.userbasket.${actionName}`, { data })
		.then(resolve, reject);
});

export default {
	namespaced: true,

	state: {
		status: 'pending',
		cartList: [],
		...window.__INITIAL_STATE__.multicart || {}
	},

	getters: {
		selected: state => state.cartList.find(cart => cart.SELECTED),
		notSelected: state => state.cartList.filter(cart => !cart.SELECTED)
	},

	mutations: {
		UPDATE_STATE(state, payload)
		{
			Vue.set(state, 'cartList', payload.cartList || []);
		},
		UPDATE_CART_LIST(state, cartList)
		{
			Vue.set(state, 'cartList', cartList);
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
		async fetch({ commit })
		{
			commit('UPDATE_STATUS');
			
			try
			{
				const result = await runAction('fetch');
				commit('UPDATE_CART_LIST', result.data);
				commit('UPDATE_STATUS', 'success');

				return result;
			}
			catch(e)
			{
				console.error(e);
				commit('UPDATE_STATUS', 'error');

				return false;
			}
		},
		select({ dispatch }, code)
		{
			return runAction('select', { code })
				.then(() => dispatch('fetch'));
		},
		remove({ dispatch }, code)
		{
			return runAction('remove', { code })
				.then(() => dispatch('fetch'));
		},
		save({ dispatch }, { name, code, color })
		{
			return runAction('remove', { name, code, color })
				.then(() => dispatch('fetch'));
		}
	}
}