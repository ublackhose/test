<template>
	<div class="mb-4">
		<div class="row justify-content-start mb-4"> 
			<div class="col-3">
				<div class="kt-input-icon kt-input-icon--left">
					<input type="text" class="form-control" :placeholder="messages.RS_B2B_CS_SEARCH_MODIFICATION" v-model="searchQuery">
					<span class="kt-input-icon__icon kt-input-icon__icon--left">
						<span><i class="la la-search"></i></span>
					</span>
				</div>
			</div>
		</div>
		<vue-table
			:columns="columns"
			:rows="rows"
			:pagination-options="{
				enabled: true,
				mode: 'records',
				perPage: 10,
				position: 'bottom',
				perPageDropdown: [5, 10, 15, 20],
				dropdownAllowAll: false,
			}"
			:search-options="{ 
				enabled: true,
				externalQuery: searchQuery,
				searchFn: handleSearch 
			}"
			ref="table"
		>
			<template slot="table-row" slot-scope="props">
				<template v-if="props.column.field == 'name'">
					<NameField :row="row" :product="row.products[props.row.id]" view="sku" :useImageFromGroupingItem="false" />
				</template>
				<template v-if="props.column.field == 'props'">
					<SkuAsPropsField :row="row" :product="row.products[props.row.id]" />
				</template>
				<template v-if="props.column.field === 'instock'">
					<InStockField :row="row" :product="row.products[props.row.id]" />
				</template>
				<template v-if="props.column.field === 'quantity'" >
					<QuantityField :product="props.row" v-model="quantities[props.row.id]" />
				</template>
				<template v-if="props.column.field === 'actions'">
					<ActionsField :row="row" :product="row.products[props.row.id]" :quantity="quantities[props.row.id]" />
				</template>
				<template v-if="props.column.field.startsWith('catalog_price_scale_')">
					<PriceField :row="row" :product="row.products[props.row.id]" :type="props.column.field" :quantity="quantities[props.row.id]" />
				</template>
			</template>

		</vue-table>
	</div>
</template>
<script>
import NameField from './fields/NameField.vue';
import InStockField from './fields/InstockField.vue';
import SkuAsPropsField from './fields/SkuAsPropsField.vue';
import PriceField from './fields/PriceField.vue'; 
import QuantityField from './fields/QuantityField.vue';
import ActionsField from './fields/ActionsField.vue';
import { getProductName, getVendorCode, checkQuantityRange } from './utils';

export default {
	components: {
		'vue-table': B2BPortal.Vue.Components.VueTable,
		'vue-dropdown': B2BPortal.Vue.Components.Dropdown,
		NameField,
		InStockField,
		SkuAsPropsField,
		PriceField,
		QuantityField,
		ActionsField
	},

	props: {
		row: {
			type: Object,
			default: () => {}
		}
	},

	data() {
		return {
			quantities: Object.keys(this.row.products)
				.reduce((obj, key) => { 
					obj[key] = this.row.products[key].ratio || 1; return obj 
				}, {}),
			columns: [],
			priceIndex: 0,
			searchQuery: ''
		};
	},

	created()
	{
		this.columns = [];

		this.columns.push({ field: 'name', html: true, label: BX.message('RS.B2BPORTAL.TABLE.HEADERS.NAME'),  sortable: false});
		this.columns.push({ field: 'props', html: true, label: BX.message('RS.B2BPORTAL.TABLE.HEADERS.PROPS'), sortable: false });
		this.columns.push({ 
			field: 'instock',
			html: true, 
			label: BX.message('RS.B2BPORTAL.TABLE.HEADERS.AVAILABLE'), 
			sortable: true,
			sortFn: (x, y, col, rowX, rowY) => {
				const instockX = parseFloat(rowX.inStock);
				const instockY = parseFloat(rowY.inStock);

				return (instockX < instockY ? -1 : (instockX > instockY ? 1 : 0));
			}
		});
		this.prices.forEach(price => {
			this.columns.push({
				field: 'catalog_price_scale_' + price.id,
				html: true,
				label: price.title,
				sortable: true,
				sortFn: (x, y, col, rowX, rowY) => {
					const quantityX = this.quantities[rowX.id] || rowX.ratio;
					const rangeX =  Object.values(rowX.quantityRanges).find(range => checkQuantityRange(range, quantityX));
					const priceX = rangeX ? rowX.prices[rangeX.hash][col.field + '_num'] : 0;

					const quantityY = this.quantities[rowY.id] || rowY.ratio;
					const rangeY =  Object.values(rowY.quantityRanges).find(range => checkQuantityRange(range, quantityY));
					const priceY = rangeX ? rowY.prices[rangeY.hash][col.field + '_num'] : 0;

					return (priceX < priceY ? -1 : (priceX > priceY ? 1 : 0));
				}
			});
		});
		this.columns.push({ field: 'quantity', html: true, label: BX.message('RS.B2BPORTAL.TABLE.HEADERS.QUANTITY'), sortable: false});
		this.columns.push({ field: 'actions', label: '', sortable: false, tdClass: 'text-center', thClass: 'text-center'});
	},

	computed: {
		rows()
		{
			return Object.values(this.row.products);
		},

		skuProps() 
		{
			return this.$store.getters[`${this.$root.$namespace}/getSkuPropsByIblockId`](this.row.iblockId);
		},

		prices()
		{
			return this.$store.getters[`${this.$root.$namespace}/getPrices`] || [];
		},

		selectedPrice()
		{
			return this.prices[this.priceIndex] || {};
		},

		priceType()
		{
			return 'catalog_price_scale_' + this.selectedPrice.id;
		},

		pricesVariants()
		{
			return this.prices.map(price => ({
				text: price.title 
			}))
		},

		messages()
		{
			return Object.freeze({
				'RS_B2B_CS_SEARCH_MODIFICATION': BX.message('RS_B2B_CS_SEARCH_MODIFICATION')
			});
		}
	},

	methods: {
		changePrice(selectPrice)
		{
			this.priceIndex = this.prices.findIndex(price => price.id == selectPrice.id);
		},

		changedQuantity(productId, newQuantity) {
			quantities[productId] = newQuantity;
		},

		searchFn(value, searchTerm)
		{
			return String(value).toLowerCase().indexOf(String(searchTerm).toLowerCase()) > -1
		},

		handleSearch(row, col, cellValue, searchTerm)
		{
			let isFind = false;
			if (col.field === 'name')
			{
				const name = getProductName(this.row, row);
				isFind = this.searchFn(name, searchTerm);
	
				if (!isFind)
				{
					const vendorCode = getVendorCode(this.row, row);
					if (vendorCode)
					{
						isFind = this.searchFn(vendorCode, searchTerm);
					}
				}
			}
			else if (col.field === 'props')
			{
				const tree = row.tree || {};

				for (const key in tree)
				{
					const prop = this.skuProps.find(prop => prop.ID == key.substring('PROP_'.length));
					const value = (prop.VALUES[tree[key]] || {}).NAME;

					isFind = this.searchFn(value, searchTerm);
					if (isFind)
						break;
				}
			}
			
			return isFind;
		},
	}
}
</script>