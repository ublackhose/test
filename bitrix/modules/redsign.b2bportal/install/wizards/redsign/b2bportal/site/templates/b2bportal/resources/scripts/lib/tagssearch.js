export default class TagsSearch
{

	constructor(data, params)
	{
		this.data = data;
		this.params = params;

		this.$el = document.getElementById(this.data.elementDomId)
	
		this.attachTemplate()
	}

	attachTemplate()
	{
		const component = this

		this.vue = new Vue({
			el: this.$el,

			components: {
				'tagssearch': B2BPortal.Vue.Components.TagsSearch
			},

			template: `<tagssearch
				:injectHiddenInput="true"
				:injectInputName="component.data.injectInputName"
				:isSearchResultLock="component.data.isSearchResultLock"
				:isShowSpinner="component.data.isSearchResultLock"
				:items="component.data.items"
				:searchItems="component.data.searchItems"
				:messages="component.data.messages"
				@on-input="onInput"
				@on-remove="onRemove"
				@on-select="onSelect"
				/>`,

			data()
			{
				return {
					component,
				}
			},


			methods: {

				onInput(query) 
				{
					this.component.prepareSearch(query)
				},

				onRemove(index) 
				{
					this.component.onRemove(index)
				},

				onSelect(index) 
				{
					this.component.onSelect(index)
				},

			}

		})
	}

	fillParams()
	{
		this.params = {}
	}

	prepareSearch(query)
	{
		if (query && query != '')
		{
			let excludeId = []

			if ((this.data.items || []). length)
			{
				excludeId = this.data.items.map((item) => {
					return item.id
				})
			}

			let params = {
				entity: this.data.entity,
				excludeId: excludeId,
			}

			params = BX.merge(params, this.data.requestParams)

			this.search(query, params)
		}
	}

	async search(query, params)
	{
		try
		{
			this.lock()
			const result = await this.query(query, params);
			this.unlock()

			if (result.data.items)
			{
				this.fill(result.data.items)
			}

			if (result.data.errors)
			{
				result.data.errors.forEach((errorMessage) => toastr.error(errorMessage))
			}
		}
		catch (e)
		{
			if (e.errors)
			{
				e.errors.forEach((error) => toastr.error(error.message))
			}
		}
	}

	query(query, params)
	{
		return new Promise((resolve, reject) => {
			BX.ajax.runComponentAction(
				this.params.componentName,
				'tagssearch',
				{
					mode: 'class',
					data: {
						query,
						params,
					},
				}
			).then(resolve, reject)
		});
	}

	fill(items)
	{
		this.data.searchItems = items
	}

	clearSearchItems()
	{
		this.data.items = []
		this.data.searchItems = []
	}

	lock()
	{
		this.data.isSearchResultLock = true
	}

	unlock()
	{
		this.data.isSearchResultLock = false
	}

	onRemove(index)
	{
		this.data.items.splice(index, 1)
	}

	onSelect(index)
	{
		this.data.items.push(this.data.searchItems[index])
	}

}
