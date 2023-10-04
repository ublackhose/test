import VueBasketSelect from './BasketSelect.vue';

export class BasketSelect
{
	constructor(element, params)
	{
		this.element = element;
		this.params = params;

		this.attachTemplate();
	}

	attachTemplate()
	{
		const params = this.params;

		this.template = new Vue({
			el: this.element,
			store: B2BPortal.store,
			components: { VueBasketSelect },

			data()
			{
				return { params };
			},

			computed: {
				
				baskets() 
				{
					return this.$store.state.baskets;
				}
			},
		
			template: `<vue-basket-select :items="baskets" :useSharing="params.useSharing"/>	`
		});
	}
}
