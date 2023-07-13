<template>
	<VueTable
		:columns="columns"
		:rows="rows"
		:selectOptions="{enabled: true}"
		:search-options="{ enabled: true, externalQuery: searchQuery, searchFn: handleSearch }"
		@on-selected-rows-change="handleSelectedRowsChange"
		max-height="700px"
		class="vgt-responsive-static"
		:fixed-header="true"
	>
		<template slot="table-row" slot-scope="props">
			<template v-if="props.column.field == 'NAME'">
				<div style="max-width: 275px;">
					<div class="d-flex align-items-center">
						<div class="mr-3 mt-2 cart-preview-picture" v-if="props.row.PICTURE">
							<ImageField :src="props.row.PICTURE" :title="props.row.NAME" />
						</div>
						<div class="d-block">
							<div class="mb-2">
								<span class="mr-2">
									<a v-if="props.row.URL" :href="props.row.URL" target="_blank">{{ props.row.NAME }}</a>
									<span v-else>{{ props.row.NAME }}</span>
								</span>

								<div v-if="props.row.NOT_AVAILABLE" class="text-danger">
									{{ messages.SBB_BASKET_ITEM_NOT_AVAILABLE }}
								</div>

							</div>
							<div>
								<span v-if="props.row.ARTICLE" class="mr-3">{{ messages.SBB_ARTICLE }} {{ props.row.ARTICLE }}</span>
								<span class="mr-2" v-if="params.showQuantity">
									<VueStockQuantity
										:displayMode="params.quantityDisplayMode"
										:mess="params.quantityMessages"
										:relativeQuantityFactor="Number(params.quantityRelativeFactor)"
										:quantity="Number(props.row.AVAILABLE_QUANTITY)"
										:measure="props.row.MEASURE_TEXT"
										:useStocks="params.useStocks"
										:displayStocks="params.displayStocks"
										:productId="props.row.PRODUCT_ID"
										:maxQuantity="params.maxQuantity"
									/>
								</span>
							</div>
						</div>
					</div>
				</div>
			</template>

			<template v-if="props.column.field == 'QUANTITY'">
				<div class="product-amount form-inline d-inline-block mw-100" data-entity="quantity-block">
					<div class="form-group">
						<VueQuantityInput
							:min="Number(props.row.MEASURE_RATIO)"
							:max="(props.row.CHECK_MAX_QUANTITY ? props.row.AVAILABLE_QUANTITY : 999999)"
							:step="Number(props.row.MEASURE_RATIO)"
							:is-invalid="props.row.CHECK_MAX_QUANTITY && props.row.QUANTITY > props.row.AVAILABLE_QUANTITY"
							:is-disabled="props.row.NOT_AVAILABLE"
							v-model="props.row.QUANTITY"
							@change="handleQuantityAction(props.row)"
						/>
					</div>
				</div>
			</template>

			<template v-if="props.column.field == 'PRICE'">
				<div class="text-nowrap" v-html="props.row.PRICE_FORMATTED"></div>
			</template>

			<template v-if="props.column.field == 'SUM_PRICE'">
				<div class="font-weight-bold text-nowrap" v-html="props.row.SUM_PRICE_FORMATTED"></div>
			</template>

			<template v-if="props.column.field == 'ACTIONS'">
				<div class="dropdown">
					<a data-toggle="dropdown" data-boundary="viewport" role="button" href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md">
						<i class="la la-ellipsis-h"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<BasketTableActions @remove="handleRemoveAction(props.row)" @move="handleMoveAction(props.row, arguments[0])" />
					</div>
				</div>
			</template>
		</template>

		<div slot="emptystate">
			<div class="text-center py-5 my-5">{{ messages.SBB_EMPTY_BASKET_TITLE }}</div>
		</div>

	</VueTable>
</template>

<script>
import BasketTableActions from './BasketTableActions.vue';
import ImageField from './ImageField.vue';

export default {

	components: {
		BasketTableActions,
		VueTable: B2BPortal.Vue.Components.VueTable,
		VueStockQuantity: B2BPortal.Vue.Components.StockQuantity,
		VueQuantityInput: B2BPortal.Vue.Components.QuantityInput,
		ImageField
	},

	props: {
		columns: {
			type: Array,
			default: () => []
		},
		rows: {
			type: Array,
			default: () => []
		},
		params: {
			type: Object,
			default: () => {}
		}
	},

	data()
	{
		return {
			searchQuery: ''
		};
	},

	computed: {
		messages()
		{
			return (
				Object.freeze(
					Object.keys(BX.message).filter(message => message.startsWith('SBB'))
						.reduce((obj, message) => { obj[message.slice(message)] = BX.message(message); return obj; }, {})
				)
			);
		},
	},

	mounted()
	{
		(this.$root.eventBus || this).$on('inputSearchQuery', (value) => { this.searchQuery = value; });
	},

	methods: {

		handleQuantityAction(row)
		{
			if (!row.CHECK_MAX_QUANTITY || (row.CHECK_MAX_QUANTITY && row.QUANTITY <= row.AVAILABLE_QUANTITY))
			{
				(this.$root.eventBus || this).$emit('updateItemQuantity', {
					itemId: row.ID,
					productId: row.PRODUCT_ID,
					quantity: row.QUANTITY
				});
			}
		},

		handleRemoveAction(row)
		{
			(this.$root.eventBus || this).$emit('removeItem', row.ID);
		},

		handleMoveAction(row, toBasket)
		{
			(this.$root.eventBus || this).$emit('moveItem', row.PRODUCT_ID, toBasket.CODE);
		},

		handleSelectedRowsChange(params)
		{
			(this.$root.eventBus || this).$emit('selectedRowsChange', params.selectedRows);
		},

		searchFn(value, searchTerm)
		{
			return String(value).toLowerCase().indexOf(String(searchTerm).toLowerCase()) > -1
		},

		handleSearch(row, col, cellValue, searchTerm)
		{
			let isFind = false;

			isFind = this.searchFn(cellValue, searchTerm);
			if (!isFind && col.field == 'NAME')
			{
				isFind = this.searchFn(row.ARTICLE, searchTerm);
			}

			return isFind;
		},
	},
}
</script>

<style scoped>
.cart-preview-picture {
	width: 3.75rem;
    text-align: center;
}
.cart-preview-picture img {
	max-height: 3.75rem;
}

</style>