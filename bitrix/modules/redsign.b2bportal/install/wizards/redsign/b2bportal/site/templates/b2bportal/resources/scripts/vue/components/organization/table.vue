<template>
	<vue-table
		:isLoading="isLoading"
		:mode="mode"
		:columns="columns"
		:rows="rows"
		:totalRows="totalRows"
		:selectOptions="selectOptions"
		:paginationOptions="paginationOptions"
		:sortOptions="sortOptions"
		@on-page-change="onPageChange"
		@on-per-page-change="onPerPageChange"
		@on-sort-change="onChangeSort"
		@on-selected-rows-change="selectionChanged"
	>

		<template slot="table-row" slot-scope="props">
			<template v-if="props.column.field == 'name'">
				<div class="mb-2">
					<span class="mr-2">
						<a :href="props.row.url">{{ props.row.name }}</a>
					</span>
				</div>
				<div v-if="props.row.datetime_create">
					<span class="mr-2">{{ props.row.datetime_create }}</span>
				</div>
			</template>
			<template v-else-if="props.column.field == 'catalog_quantity'">
				<vue-quantity
					v-bind:quantity="Number(props.row.catalog_quantity)"
					:measure="props.row.measureTitle"
				/>
			</template>
			<template v-else-if="(props.column.field).substr(0, 20) == 'catalog_price_scale_'">
				<span class="text-nowrap">
					{{ props.row[props.column.field] }}
				</span>
			</template>
			<template v-else-if="props.column.field == 'quantity'">
				<div class="product-amount form-inline d-inline-block mw-100" data-entity="quantity-block">
					<div class="form-group">
						<input
							type="text"
							class="product-amount-field form-control form-control-sm"
							:name="$attrs.params.arParams.PRODUCT_QUANTITY_VARIABLE"
							v-model.number="props.row.quantity"
							@change="quantityChange(props.row)">
					</div>
				</div>
			</template>
			<template v-else-if="props.column.field == 'actions'">
				<template v-if="props.row.can_buy">
					<button
						ref="buttonAdd2basket"
						class="btn btn-primary"
						@click="click(props.row)"
					>
						<i class="flaticon2-shopping-cart-1 pr-0"></i>
					</button>
				</template>
				<template v-else>
					<div class="product-item-button-container"></div>
				</template>
			</template>
			<template v-else>
				{{ props.formattedRow[props.column.field] }}
			</template>
		</template>

	</vue-table>
</template>

<script>
import VueTable from '../vgt/table.vue';

export default {

	name: 'vue-organization-table',

	props: {
		isLoading: Boolean,
		mode: { default: 'remote' },
		columns: {},
		rows: {},
		totalRows: {},
		selectOptions: {},
		paginationOptions: {},
		sortOptions: {},
	},

	methods: {
		onPageChange(params)
		{
			this.$emit('on-page-change', params)
		},

		onPerPageChange(params)
		{
			this.$emit('on-per-page-change', params)
		},

		onChangeSort(params)
		{
			this.$emit('on-sort-change', params)
		},

		selectionChanged(params)
		{
			this.$emit('on-selected-rows-change', params)
		},

		click(row)
		{
			this.$emit('on-add2basket-click', row)
		},

		quantityChange(row)
		{
			this.$emit('on-quantity-change', row)
		},
	},

	components: {
		'vue-table': VueTable,
	},

}
</script>
