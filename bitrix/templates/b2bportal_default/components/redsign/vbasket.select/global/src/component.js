import BasketSelectDropdown from './BasketSelectDropdown.vue';

export class BasketsGlobal
{
	constructor(params)
	{
		this.el = params.el;

		this.baskets = params.baskets;
		this.basketUrl = params.basketUrl;

		this.initBaskets();
		this.onEvents();
		this.attachTemplate();
	}

	initBaskets()
	{
		B2BPortal.store.commit('SET_BASKETS', this.baskets);
	}

	onEvents()
	{
		BX.addCustomEvent('updateBasketComponent', () => {
			B2BPortal.store.dispatch('fetchBasket');
		});
	}

	attachTemplate()
	{
		const basketUrl = this.basketUrl; 

		this.template = new Vue({
			el: this.el,
			components: { BasketSelectDropdown },
			store: B2BPortal.store,

			data()
			{
				return { basketUrl };
			},
				

			template: `<BasketSelectDropdown :basketUrl="basketUrl" />`,
		});
	}
}