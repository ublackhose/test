export default class Filter
{

	constructor(data, params)
	{
		this.data = data

		this.params = params

		this.attachEvents()
		this.initComponents()
	}

	attachEvents()
	{
		this.params.el.$form.addEventListener('submit', (e) => {
			e.preventDefault()
			this.onSubmitSetfilter()
		})

		this.params.el.$form.reset_filter.addEventListener('click', () => {
			this.onSubmitResetfilter()
		})
	}

	initComponents()
	{
		this.initComponentTagsSearch()
		this.initComponentDateRange()
	}

	onSubmitSetfilter()
	{
		let data = BX.ajax.prepareForm(this.params.el.$form).data

		BX.onCustomEvent(`filter-${this.params.filterName}-on-submit`, [data])
	}

	onSubmitResetfilter()
	{
		let data = BX.ajax.prepareForm(this.params.el.$form).data

		this.resetFormData()

		BX.onCustomEvent(`filter-${this.params.filterName}-on-reset`, [data])
	}

	initComponentTagsSearch()
	{
		if (!this.data || !this.data.tagssearch)
			return

		this.objTagss = {};
		for (let key in this.data.tagssearch)
		{
			this.objTagss[key] = new B2BPortal.Components.TagsSearch(this.data.tagssearch[key], this.params);
		}
	}

	initComponentDateRange()
	{
		if (!this.data || !this.data.daterange)
			return

		for (let key in this.data.daterange)
		{
			$(this.data.daterange[key].selector).datepicker({
				format: 'dd.mm.yyyy',
				orientation: 'bottom right',
				autoclose: true,
			})			
		}
	}

	resetFormData()
	{
		for (let key in this.objTagss)
		{
			this.objTagss[key].clearSearchItems()
		}

		let inputs = this.params.el.$form.querySelectorAll('input')
		inputs.forEach((input) => {
			input.value = ''
		})

		let selects = this.params.el.$form.querySelectorAll('select')
		selects.forEach((select) => {
			select.value = -1
		})
	}

}
