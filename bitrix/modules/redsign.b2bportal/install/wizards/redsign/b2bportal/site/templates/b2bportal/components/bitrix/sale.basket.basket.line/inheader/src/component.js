import VueQuickBasket from './quick-basket.vue';

export class QuickBasket
{
	constructor(el, params)
	{
		this.el = el;
		this.params = params;

		this.initQuickBasket();
	}

	initQuickBasket()
	{
		const options = {
			propsData: {
				signedParameters: this.params.signedParameters,
				pathToBasket: this.params.pathToBasket,
				pathToOrder: this.params.pathToOrder,
				panel: this.params.panel
			}
		};
		this.$quickBasket = new (Vue.extend(VueQuickBasket))(options);

		const element = this.el.appendChild(document.createElement('div'));
		this.$quickBasket.$mount(element, true);
	}
}