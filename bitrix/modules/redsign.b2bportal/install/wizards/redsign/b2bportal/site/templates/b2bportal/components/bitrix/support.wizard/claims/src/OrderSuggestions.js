import VueOrderSuggestions from './VueOrderSuggestions.vue';

export class OrderSuggestions
{
	constructor(el, options)
	{
		this.$el = el;
		this.options = options;

		this.attachTemplate();
	}

	attachTemplate()
	{
		const inputName = this.options.inputName || '';
		const value = this.options.value || '';

		this.template = new Vue({
			components: { VueOrderSuggestions },
			el: this.$el,

			data()
			{
				return {
					inputName, 
					value
				};
			},

			template: `<VueOrderSuggestions :name="inputName" :value="value" />`
		});
	}
}