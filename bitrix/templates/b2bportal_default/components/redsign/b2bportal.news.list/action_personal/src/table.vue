<template>
	<vue-table
		:isLoading="isLoading"
		:mode="mode"
		:columns="columns"
		:rows="rows"
		:totalRows="totalRows"
		:selectOptions="selectOptions"
		:paginationOptions="paginationOptions"
		:sortOptions="sortParams"
		@on-page-change="onPageChange"
		@on-per-page-change="onPerPageChange"
		@on-sort-change="onChangeSort"
		@on-selected-rows-change="selectionChanged"
		ref="table"
	>

		<template slot="table-row" slot-scope="props">
			<template v-if="props.column.field == `PROPERTY_${$attrs.params.arParams.PROPERTY_CODE_ID.TYPE}`">
				<span
					v-if="props.row[`PROPERTY_${$attrs.params.arParams.PROPERTY_CODE_ID.TYPE}`]"
					class="kt-badge kt-badge--inline kt-badge--pill"
					:class="props.row.property_type_badge"
				>
					{{ props.row[`PROPERTY_${$attrs.params.arParams.PROPERTY_CODE_ID.TYPE}`] }}
				</span>
			</template>
			<template v-else-if="props.column.field == `PROPERTY_${$attrs.params.arParams.PROPERTY_CODE_ID.OWNER_ID}`">
				<a
					v-if="props.row[`PROPERTY_${$attrs.params.arParams.PROPERTY_CODE_ID.OWNER_ID}_url`]"
					:href="props.row[`PROPERTY_${$attrs.params.arParams.PROPERTY_CODE_ID.OWNER_ID}_url`]"
					target="_blank"
				>
					{{ props.row[`PROPERTY_${$attrs.params.arParams.PROPERTY_CODE_ID.OWNER_ID}_display`] }}
				</a>
				<span v-else>{{ props.row[`PROPERTY_${$attrs.params.arParams.PROPERTY_CODE_ID.OWNER_ID}_display`] }}</span>
			</template>
			<template v-else-if="props.column.field == `PROPERTY_${$attrs.params.arParams.PROPERTY_CODE_ID.ORDER_ID}`">
				<a
					v-if="props.row[`PROPERTY_${$attrs.params.arParams.PROPERTY_CODE_ID.ORDER_ID}_url`]"
					:href="props.row[`PROPERTY_${$attrs.params.arParams.PROPERTY_CODE_ID.ORDER_ID}_url`]"
					target="_blank"
				>
					#{{ props.row[`PROPERTY_${$attrs.params.arParams.PROPERTY_CODE_ID.ORDER_ID}_display`] }}
				</a>
			</template>
			<template v-else-if="props.column.field == 'actions'">
				<a v-if="props.row.download_link" :href="props.row.download_link" class="btn btn-primary btn-sm" target="_blank">
					<i class="flaticon2-download-2 pr-0"></i>
				</a>
			</template>
			<template v-else>
				{{ props.formattedRow[props.column.field] }}
			</template>
		</template>

	</vue-table>
</template>

<script>
export default {

	name: 'vue-docs-table',

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

	data()
	{
		return {
			sortParams: this.sortOptions,
		};
	},

	mounted()
	{
		this.setRowsIds();
		this.setEditAreas();
	},

	computed:
	{

		editAreas()
		{
			return this.$store.getters["NewsList/editAreas"];
		},

		editAreaIds()
		{
			return Object.keys(this.editAreas).filter(areaId => this.rows.find(row => row.editAreaId == areaId));
		},

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
		},

	},

	components: {
		'vue-table': B2BPortal.Vue.Components.VueTable
	},

	watch: {
		rows()
		{
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
	},

}
</script>
