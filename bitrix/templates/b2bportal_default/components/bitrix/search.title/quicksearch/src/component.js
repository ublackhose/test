import VueQuickSearch from './vue-quick-search.vue';

export class QuickSearch
{
	constructor(element, params)
	{
		this.element = element;
		this.params = params;

		this.attachTemplate();
	}

	attachTemplate()
	{

		const params = {
			propsData: {
				action: this.params.action,
				ajaxUrl: this.params.ajaxUrl,
				inputId: this.params.inputId,
				inputName: this.params.inputName,
				minLength: this.params.minLength
			}
		};

		this.template = new (Vue.extend(VueQuickSearch))(params);
		this.template.$mount(this.element);
	}
}