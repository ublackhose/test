import StoreList from './StoreList.vue';

export class CatalogStoreAmount
{
	constructor(data, params)
	{
		this.data = data
		this.params = params

		this.attachTemplates()
	}

	attachTemplates()
	{
		this.attachTemplateStoreList()
	}

	attachTemplateStoreList()
	{
		const $element = document.getElementById(`${this.params.blockId}-store-amount`)
		const rows = this.data
		const arParams = this.params.arParams

		new Vue({
			el: $element,

			components: { StoreList },

			data()
			{
				return {
					rows,
					arParams,
				}
			},

			template: `<StoreList v-bind="{ rows, arParams }" />`,
		})
	}

}
