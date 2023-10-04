import ProductTable from './ProductTable.vue';
import { createStore, INITIAL_STATE } from './store.js';
import VueToolbar from './VueToolbar.vue';
import { addItemsToBasket } from './api';

const { store } = B2BPortal;

export class CatalogSection extends B2BPortal.Components.TableFilter
{
	constructor(data, params)
	{
		super(data, params);
		this.init();
		this.attachTemplateToolbar();
		
		BX.addCustomEvent(
			`filter-${this.params.filter.filterName}-on-submit`,
			(data, url) => {
				this.params.arParams.AJAX_URL = url || this.params.arParams.AJAX_URL;
			}
		)
	}

	init()
	{
		this.namespace = `component_${this.params.id}`;

		const settings = { 
			...INITIAL_STATE.settings,
			preview: this.params.arParams['ENABLE_PREVIEW_PICTURE'],
			views: this.params.arParams['SHOW_VIEWS_TEMPLATES']
		};

		const initialState = { 
			...INITIAL_STATE,
			prefix: this.params.arParams['STORAGE_PREFIX'],
			settings: { ...settings },
			toolbar: { ...this.params.toolbar },
			skuProps: { ...this.params.skuProps },
			prices: [ ...this.data.prices ]
		}
		
		store.registerModule(this.namespace, createStore(initialState));
		store.dispatch(`${this.namespace}/initial`);

		super.init();
	}
	
	setEditAreas(editAreas)
	{
		store.dispatch(`${this.namespace}/setEditAreas`, editAreas);
	}

	handleEvents() 
	{ 
		this.eventBus.$on('afterRequest', result => this.afterRequest(result));
		this.eventBus.$on('buy', params => this.add2basket(params.product, params.quantity));
		this.eventBus.$on('onSortChange', params => this.requestChangeSort(params));
		this.eventBus.$on('onPageChange', params => this.handlePageChange(params));
		this.eventBus.$on('onPerPageChange', params => this.handlePerPageChange(params));
		this.eventBus.$on('onSelectedRowsChanged', selectedRows => this.selectedRows = selectedRows);
	}

	afterRequest({ data })
	{
		if (!data)
			return;

		if (data.skuProps) 
			store.dispatch(`${this.namespace}/setSkuProps`, data.skuProps);

		if(data.editAreas)
			store.dispatch(`${this.namespace}/setEditAreas`, data.editAreas);
	}

	handlePageChange(params)
	{
		if (params.currentPage == this.data.pagination.setCurrentPage)
		{
			return;
		}

		this.requestPageChange(params);
	}

	handlePerPageChange(params)
	{
		if (params.currentPerPage == this.data.pagination.perPage)
		{
			return;
		}

		this.data.pagination.perPage = null;

		this.requestPerPageChange(params);
	}
	
	attachTemplates()
	{
		this.attachTemplateProductTable();
	}

	attachTemplateProductTable()
	{
		const data = this.data;
		const params = this.params;
		const eventBus = this.eventBus;
		const namespace = this.namespace;

		this.vueTable = new Vue({
			el: this.$table,
			components: { ProductTable },
			store,
			props: {
				isLoading: {
					type: Boolean,
					default: false,
				},
			},
 
			data()
			{ 
				return {
					data,
					params,
				}
			},

			beforeCreate() 
			{
				this.$namespace = namespace;
				this.$eventBus = eventBus; 
			},

			computed: {

				enablePagination()
				{ 
					if (this.data.pagination.hide == 'Y')
					{
						let minPerPage = Math.min(...this.params.pagination.perPageDropdown)
						if (this.data.pagination.totalRecords <= minPerPage)
						{
							return false
						}
					}

					return true
				},

				enableSelect()
				{
					if (this.data.pagination.hide == 'Y' && this.data.items.length < 2)
					{
						return false
					}

					return true
				},

				view()
				{
					return this.params.arParams.RS_VIEW_MODE === 'compact' ? 'compact' : 'base';
				},
			},

			template: `
				<ProductTable
					:isLoading="isLoading"
					:view="view"
					:columns="data.headers"
					:rows="data.items"
					:pagination-options="{
						enabled: enablePagination,
						setCurrentPage: data.pagination.currentPage,
						perPage: data.pagination.perPage,
						perPageDropdown: params.pagination.perPageDropdown,
					}"
					:totalRows="data.pagination.totalRecords"
					:select-options="{
						enabled: enableSelect,
					}"
					:sort-options="{
						enabled: true,
						initialSortBy: {
							field: params.sorting.initialSortBy.field,
							type: params.sorting.initialSortBy.type,
						}
					}"
				/>
			`, 
		}); 
	}

	attachTemplateToolbar()
	{
		const self = this;
		const eventBus = this.eventBus;
		const namespace = this.namespace;

		const el = document.createElement('div');
		const $parent = document.querySelector(`#${this.params.block} .kt-portlet__head-toolbar`);
		if ($parent)
		{
			$parent.appendChild(el);
	
			const components = { VueToolbar }
	
			this.toolbar = new Vue({
				el,
				store,
				components,
	
				beforeCreate() 
				{
					this.$namespace = namespace;
					this.$eventBus = eventBus; 
				},
	
				methods: {
					addtobasket: self.add2basketRows.bind(self)
				},
	
				template: `<VueToolbar @addtobasket="addtobasket"/>`
			});
		}
	}

	async add2basket(itemId, quantity)
	{
		let url = this.params.arParams.BASKET.ADD_URL_TEMPLATE;
		url = url.replace('#ID#', itemId);

		let data = {
			'ajax_basket': 'Y',
			[this.params.arParams.PRODUCT_QUANTITY_VARIABLE]: quantity,
		};

		try
		{
			let result = await this.requestPost(url, data)

			if (result.STATUS == 'OK' && result.MESSAGE)
			{
				store.commit('cart/ADD_ITEM_TO_CART', {
					itemId: itemId,
					quantity: Number(quantity)
				});

				this.showSuccess(result.MESSAGE);
				
				this.eventBus.$emit('clearQuantity', itemId); 

				BX.onCustomEvent('updateBasketComponent');
				store.dispatch('cart/fetch');
			}
			else
			{
				this.showError(result.MESSAGE ? result.MESSAGE : 'Unknown error');
			} 
		} 
		catch (e) 
		{
			
			if (e.errors)
			{
				e.errors.forEach((error) => this.showError(error.message));
			}
			else
			{
				console.error(e);
				this.showError('Undefined error');
			}
		}
	}

	async add2basketRows(rows)
	{
		const items = rows
			.filter(row => (row.products[row.selected] || {}).canBuy)
			.map(row => ({
				productId: row.selected,
				quantity: row.quantity,
			})); 

		try
		{
			store.dispatch('cart/addFewItemsToCart', items);
			window.toastr.success(BX.message('RS.B2BPORTAL.ADD2BASKET_SUCCESS'));
			this.eventBus.$emit('unselectRows');
			BX.onCustomEvent('updateBasketComponent');
			items.forEach(({ productId }) => {
				this.eventBus.$emit('clearQuantity', productId); 
			});
		}
		catch (e)
		{
			console.error(e);
			window.toastr.error(BX.message('RS.B2BPORTAL.ADD2BASKET_ERROR'));
		}
	}
}
