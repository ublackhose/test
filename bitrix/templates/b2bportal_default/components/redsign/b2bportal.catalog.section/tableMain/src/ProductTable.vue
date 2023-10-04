<template>
	<vue-table
		:isLoading="isLoading"
		:mode="mode"
		:columns="visibleColumns"
		:rows="rowsMask"
		:totalRows="totalRows"
		:selectOptions="selectOptions"
		:paginationOptions="paginationOptions"
		:sortOptions="sortParams"
		:expandedRows="expandedRows"
		@on-sort-change="handleSortChange"
		@on-page-change="handlePageChange"
		@on-per-page-change="handlePerPageChange"
		@on-selected-rows-change="handleSelectedRowsChanged"
		ref="table"
	>

		<template slot="table-row" slot-scope="props">
			<template v-if="props.column.field == 'name'">
				<NameField :row="rows[props.index]" :product="getProduct(rows[props.index])" v-if="view !== 'compact'" />
				<CompactNameField :row="rows[props.index]" :product="getProduct(rows[props.index])" v-else />
			</template>

			<template v-if="props.column.field == 'sku'">
				<SkuField :row="rows[props.index]" :product="getProduct(rows[props.index])" />
			</template>

			<template v-if="props.column.field == 'properties'">
				<PropertiesField :row="rows[props.index]" :product="getProduct(rows[props.index])" />
			</template>

			<template v-if="props.column.field == 'instock'">
				<InStockField :row="rows[props.index]" :product="getProduct(rows[props.index])" />
			</template>

			<template v-if="props.column.field.startsWith('catalog_price_scale_')">
				<PriceField :row="rows[props.index]" :product="getProduct(rows[props.index])" :type="props.column.field" :quantity="rows[props.index].quantity" />
			</template>

			<template v-if="props.column.field == 'quantity'">
				<QuantityField :row="rows[props.index]" :product="getProduct(rows[props.index])" v-model="rows[props.index].quantity" />
			</template>

			<template v-if="props.column.field == 'actions'">
				<ActionsField :row="rows[props.index]" :product="getProduct(rows[props.index])" :quantity="rows[props.index].quantity" />
			</template>
		</template> 

		<template slot="expanded-row" slot-scope="props">
			<SkuTable :row="rows[props.index]"/>
		</template>

	</vue-table>
</template>

<script>
import CompactNameField from './fields/CompactNameField.vue';
import NameField from './fields/NameField.vue';
import SkuField from './fields/SkuField.vue';
import PropertiesField from './fields/PropertiesField.vue';
import InStockField from './fields/InstockField.vue';
import PriceField from './fields/PriceField.vue';
import QuantityField from './fields/QuantityField.vue';
import ActionsField from './fields/ActionsField.vue';
import SkuTable from './SkuTable.vue';

export default { 
 
	name: 'vue-product-table',

	components: {
		CompactNameField,
		NameField,
		SkuField,
		InStockField,
		PriceField,
		QuantityField,
		ActionsField,
		PropertiesField,
		SkuTable,

		'vue-table': B2BPortal.Vue.Components.VueTable
	},

	props: {
		isLoading: Boolean,
		mode: { default: 'remote' },
		view: {
			type: String,
			default: 'base'
		},
		columns: {
			type: Array,
			default: () => []
		},
		rows: {
			type: Array,
			default: () => []
		},
		totalRows: {
			type: [String, Number],
			default: ''
		},
		selectOptions: {
			type: Object,
			default: () => {}
		},
		paginationOptions: {
			type: Object,
			default: () => {}
		},
		sortOptions: {
			type: Object,
			default: () => {}
		}
	},

	data()
	{
		return {
			sortParams: this.sortOptions,
			rowsAreas: []
		};
	},

	computed:
	{

		fields()
		{
			return Object.freeze([ 'name', 'sku', 'properties', 'instock', 'quantity', 'actions']);
		},

		expandedRows()
		{
			const rows = this.rows;

			return rows.reduce((indexes, row, index) => {
				if (row._IS_EXPAND) indexes.push(index);

				return indexes;
			}, []);
		},

		visibleColumns()
		{
			return this.columns.map(column => {

				switch(column.field)
				{
					case 'sku':
						column.hidden = !!!this.rows.find(row => Object.prototype.toString.call(row.sku) === '[object Object]');
						break;

					case 'properties':
						column.hidden = !!!this.rows.find(row => row.props.length);
						break;
				}

				return column;
			})
		},

		rowsMask()
		{
			return this.rows.map(row => ({}));
		},

		eventBus()
		{
			return this.$root.$eventBus || this;
		},
		
		editAreas()
		{
			return this.$store.getters[`${this.$root.$namespace}/getEditAreas`];
		}, 

		editAreaIds()
		{
			return Object.keys(this.editAreas).filter(areaId => this.rows.find(row => row.editAreaId == areaId));
		}
	},

	created()
	{
		this.rows.forEach(row => this.$set(row, '_IS_EXPAND', false));
	},

	mounted()
	{
		this.setRowsIds();
		this.setEditAreas();

		this.eventBus.$on('unselectRows', () => {
			this.$refs.table.unselectAllInternal();
		});
	},

	methods: {

		getProduct(row)
		{
			return row.products[row.selected] || null;
		},
 
		handleSortChange(params)
		{
			this.eventBus.$emit('onSortChange', params[0])
		},

		handlePageChange(params)
		{
			this.eventBus.$emit('onPageChange', params);
		},

		handlePerPageChange(params)
		{
			this.eventBus.$emit('onPerPageChange', params);
		},

		handleSelectedRowsChanged(params)
		{
			const selectedRows = this.rows.filter((row, index) => params.selectedRows.find(selectedRow => selectedRow.originalIndex === index));
			this.eventBus.$emit('onSelectedRowsChanged', selectedRows);
		},

		setRowsIds()
		{
			const table = this.$refs.table;
			const tableRows = table.$refs.rows;

			tableRows.forEach((row, index) => {
				row.setAttribute('id', this.rows[index].editAreaId);
			});
		},

		setEditAreas()
		{
			this.editAreaIds.forEach(areaId => {
				if (BX(areaId))
				{
					(new BX.CMenuOpener({
						'parent': areaId,
						'menu': [{
							'ICONCLASS': 'bx-context-toolbar-edit-icon',
							'TITLE': '',
							'TEXT': this.editAreas[areaId].edit.text,
							'ONCLICK': "(new BX.CAdminDialog({'content_url': '" + this.editAreas[areaId].edit.link + "' })).Show()"
						}, {
							'ICONCLASS': 'bx-context-toolbar-delete-icon',
							'TITLE': '',
							'TEXT': this.editAreas[areaId].delete.text,
							'ONCLICK': 'if(confirm(\'Are you sure?\')) jsUtils.Redirect([], ' + this.editAreas[areaId].delete.link + ');'
						}]
					})).Show();
		
					BX.admin.setComponentBorder(areaId);
				}
			});
		}

	},

	watch: {
		rows()
		{
			this.rows.forEach(row => this.$set(row, '_IS_EXPAND', false));

			this.$nextTick(() => {
				this.setRowsIds();
			});
		},

		editAreaIds()
		{
			this.$nextTick(() => {
				this.setEditAreas();
			});
		}
	}
}
</script>
