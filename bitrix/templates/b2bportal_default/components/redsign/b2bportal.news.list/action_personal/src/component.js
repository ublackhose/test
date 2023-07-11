import VueDocsTable from './table.vue';
import store from './store.js';

B2BPortal.store.registerModule('NewsList', store)

export class DocsTable extends B2BPortal.Components.TableFilter
{

	constructor(data, params)
	{
		super(data, params)

		this.init()
	}

	handleEvents()
	{
		this.eventBus.$on('afterRequest', result => this.afterRequest(result));
	}

	afterRequest(result)
	{
		if (result.data)
		{
			if (result.data.editAreas)
			{
				for (let id in result.data.editAreas)
				{
					B2BPortal.store.commit(
						'NewsList/ADD_EDIT_AREA', 
						{ id, actions: result.data.editAreas[id] }
					);
				}
			}
		}
	} 

	attachTemplateTable()
	{
		const data = this.data
		const params = this.params
		const component = this

		this.vueTable = new Vue({
			el: this.$table,

			props: {
				isLoading: {
					type: Boolean,
					default: false,
				},
			},

			components: { VueDocsTable },

			store: B2BPortal.store,

			template: `
				<VueDocsTable
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
						enabled: false,
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

}
