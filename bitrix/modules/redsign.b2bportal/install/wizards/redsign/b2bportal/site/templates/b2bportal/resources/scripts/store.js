import stocks from './vue/store/stock'
import cart from './vue/store/cart';
import multicart from './vue/store/multicart';

Vue.use(Vuex);
 
const store = new Vuex.Store({
	state: {
		baskets: []
	},
	getters: {

		notSelectedBaskets(state)
		{
			return state.baskets.filter(basket => !basket.SELECTED);
		}, 

		selectedBasket(state)
		{
			return state.baskets.filter(basket => basket.SELECTED).shift();
		}
	
	},

	mutations: {

		SET_BASKETS(state, baskets)
		{
			state.baskets = baskets;
		},

	},

	actions: {

		async saveBasket({ dispatch }, values )
		{
			const result = await dispatch('runBasketAction', {
				actionName: 'save',
				data: {
					name: values.name,
					color: values.color,
					code: values.code
				}
			});

			if (result.status !== 'error')
			{
				if (result.data.isSuccess)
				{
					await dispatch('fetchBasket');
				}
				else
				{
					toastr.error(result.data.errorMessage);
				}
			}


			return result.data;
		},

		async removeBasket({ dispatch, getters }, code)
		{ 
			const result = await dispatch('runBasketAction', {
				actionName: 'remove',
				data: { code }
			});

			if (result.data.isSuccess)
			{
				if (getters.selectedBasket.CODE == code)
				{
					BX.reload();
				}
				else
				{
					dispatch('fetchBasket');
				} 
			}
			else
			{
				toastr.error(result.data.errorMessage);
			}
		},

		async selectBasket({ dispatch }, code)
		{
			await dispatch('runBasketAction', { 
				actionName: 'select',
				data: { code }
			}); 

			BX.reload();
		},

		async fetchBasket({ dispatch, commit })
		{
			const result = await dispatch('runBasketAction', {
				actionName: 'fetch'
			});

			if (result.data.length)
			{
				commit('SET_BASKETS', result.data);
			}
		},

		async runBasketAction({ commit } , params)
		{
			let result;

			try
			{
				result = await new Promise((resolve, reject) => {
					BX.ajax.runAction(
						'redsign:vbasket.api.userbasket.' + params.actionName,
						{
							data: params.data,
						}
					).then(resolve, reject);
				});
			}
			catch(e)
			{
				result = e;
				if (e.errors && e.errors.length)
				{	
					toastr.error(e.errors[0].message)
				}
			}

			return result;
		},

		initialize({ commit, dispatch }, payload)
		{
			dispatch('cart/initialize', payload.cart);
			dispatch('multicart/initialize', payload.multicart);

			if (payload.baskets)
				commit('SET_BASKETS', payload.baskets);
		}
	}
});    

store.registerModule('multicart', multicart); 
store.registerModule('cart', cart);
store.registerModule('stocks', stocks);

export default store;