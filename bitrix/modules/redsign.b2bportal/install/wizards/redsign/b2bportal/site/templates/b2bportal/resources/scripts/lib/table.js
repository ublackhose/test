export default class Table
{

	constructor(data, params)
	{
		this.$table = document.getElementById(params.table)

		this.data = data

		this.params = params

		this.loading = false

		this.selectedRows = {}

		this.requestData = {}

		this.eventBus = new Vue();
	}
	
	init()
	{
		this.handleEvents();
		this.attachTemplates()
	}

	handleEvents()
	{
		
	}

	attachTemplates()
	{
		this.attachTemplateTable();
	}

	attachTemplateTable()
	{
		const data = this.data
		const params = this.params
		const component = this

		this.table = new Vue({
			el: this.$table,

			props: {
				isLoading: {
					type: Boolean,
					default: false,
				},
			},

			components: {
				'vue-table': B2BPortal.Vue.Components.VueTable,
				'dropdown-select': B2BPortal.Vue.Components.Select,
			},

			template: `
				<vue-table
					:isLoading="component.loading"
					:columns="data.headers"
					:rows="data.items"
					:pagination-options="{
						enabled: true,
						setCurrentPage: data.pagination.currentPage,
						perPage: data.pagination.perPage,
						perPageDropdown: params.pagination.perPageDropdown,
					}"
					:totalRows="data.pagination.totalRecords"
					:select-options="{
						enabled: true,
					}"
					:sort-options="{
						enabled: true,
						initialSortBy: {
							field: params.sorting.initialSortBy.field,
							type: params.sorting.initialSortBy.type,
						}
					}"
					:params="params"
					:component="component"
					@on-page-change="onPageChange"
					@on-per-page-change="onPerPageChange"
					@on-sort-change="onChangeSort"
					@on-selected-rows-change="onSelectedRowsChange"
				/>
				`,

			data()
			{
				return {
					data,
					params,
					component,
				}
			},

			methods: {

				onSelectedRowsChange(selectedParams)
				{
					this.component.selectedRows = selectedParams.selectedRows
				},

				onPageChange(paginationParams)
				{
					if (paginationParams.currentPage == this.data.pagination.setCurrentPage)
						return

					this.component.requestPageChange(paginationParams)
				},

				onPerPageChange(perPageParams)
				{
					if (perPageParams.currentPerPage == this.data.pagination.perPage)
						return

					this.data.pagination.perPage = null

					this.component.requestPerPageChange(perPageParams)
				},

				onChangeSort(sortParams)
				{
					this.component.requestChangeSort(sortParams[0])
				},

			},
		
		});
	}

	requestPageChange(paginationParams)
	{
		this.requestData[this.getPagenName()] = this.getPagenValue(paginationParams.currentPage)

		this.makeRequest()
	}

	requestPerPageChange(perPageParams)
	{
		this.requestData[this.params.arParams.CATALOG_SORTER.ACTION_CHANGE_PERPAGE] = perPageParams.currentPerPage
		delete this.requestData[this.getPagenName()]

		this.makeRequest()
	}

	requestChangeSort(sortParams)
	{
		this.requestData[this.params.arParams.CATALOG_SORTER.ACTION_CHANGE_SORT] = sortParams.field + '|' + sortParams.type
		delete this.requestData[this.getPagenName()]

		this.makeRequest()
	}

	async makeRequest(url = null)
	{
		this.showLoading()

		try
		{
			let data = this.getRequestData()
			let result = await this.requestGet(url || this.params.arParams.AJAX_URL, data)

			if ((result.data.errors || []).length)
			{
				result.data.errors.forEach((errorMessage) => this.showWarning(errorMessage))
			}
			
			if ((result.data.items || []).length)
			{
				this.data.items = result.data.items
			}
			else if (result.data.items)
			{
				this.data.items = []
			}

			if ((Object.keys(result.data.pagination) || []).length)
			{
				this.data.pagination = result.data.pagination
			}

			if (result.data.setUrl && result.data.setUrl != '')
			{
				BX.ajax.history.put(null, result.data.setUrl)
			}

			this.eventBus.$emit('afterRequest', result);
		}
		catch (e)
		{
			if (e.errors)
			{
				e.errors.forEach((error) => this.showError(error.message));
			}
			else
			{
				console.warn(e);
				this.showError('Undefined error');
			}
		}
		finally
		{
			this.hideLoading()
		}
	}

	requestGet(url, data)
	{
		url = this.add_url_param(url, data)

		return this.request(url, {})
	}

	requestPost(url, data)
	{
		return this.request(url, data)
	}

	request(url, data)
	{
		return BX.ajax.promise({
			method: 'POST',
			dataType: 'json',
			url: url,
			data: { ...data, comp_id: this.params.id },
		}).then((response) => {
			return response
		}).catch((response) => {
			let ajaxReject = new BX.Promise()
	
			if (BX.type.isPlainObject(response) && response.status && response.hasOwnProperty('data'))
			{
				ajaxReject.reject(response)
			}
			else
			{
				ajaxReject.reject({
					status: 'error',
					data: {
						ajaxRejectData: response
					},
					errors: [
						{
							code: 'NETWORK_ERROR',
							message: 'Network error'
						}
					]
				})
			}
	
			return ajaxReject
		})
	}

	getPagenName()
	{
		return this.data.pagination.navName
	}

	getPagenValue(value)
	{
		if (!!this.data.pagination.navPageValuePrefix)
		{
			return `${this.data.pagination.navPageValuePrefix}${value}`
		}
		else
		{
			return value
		}
	}

	getRequestData()
	{
		let curData = {}

		return BX.merge(this.requestData, curData)
	}

	add_url_param(url, params)
	{
		let additional = ''
		let hash = ''
		let pos

		url = this.remove_url_param(url, params)

		additional = this.get_param_string(params)

		if ((pos = url.indexOf('#')) >= 0)
		{
			hash = url.substr(pos)
			url = url.substr(0, pos)
		}

		if ((pos = url.indexOf('?')) >= 0)
		{
			url = url + (pos != url.length-1? '&' : '') + additional + hash
		}
		else
		{
			url = url + '?' + additional + hash
		}

		return url
	}

	remove_url_param(url, arParams)
	{
		let pos
		let param
		let params

		if ((pos = url.indexOf('?')) >= 0 && pos != url.length-1)
		{
			for (param in arParams)
			{
				params = url.substr(pos + 1);
				url = url.substr(0, pos + 1);

				params = params.replace(new RegExp(`(^|&)${param}=[^&#]*`, 'i'), '')
				params = params.replace(new RegExp(`(^|&)${param}%5B[0-9]*%5D=[^&#]*`, 'igs'), '')
				params = params.replace(/^&/, '')

				if (BX.type.isNotEmptyString(params))
				{
					url = url + params
				}
			}
		}

		return url
	}

	get_param_string(params, name = '')
	{
		let additional = ''
		let param

		for (param in params)
		{
			if (BX.type.isArray(params[param]))
			{
				additional += 
					(additional != ''? '&':'')
					+ this.get_param_string(params[param], param + BX.util.urlencode('[]'))
			}
			else
			{
				if (!params[param] || params[param] == '')
					continue

				additional +=
					(additional != ''? '&':'')
					+ (name && name != '' ? name : param)
					+ '='
					+ params[param];
			}
		}

		return additional
	}

	showSuccess(message)
	{
		window.toastr.success(
			message
		); 
	}

	showError(message)
	{
		window.toastr.error(
			message
		); 
	}

	showWarning(message)
	{
		window.toastr.warning(
			message
		); 
	}

	showLoading(message = '')
	{
		// this.loading = true
		KTApp.block(`#${this.params.block}`);
	}

	hideLoading()
	{
		// this.loading = false
		KTApp.unblock(`#${this.params.block}`);
	}

}
