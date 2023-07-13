<template>
	<div class="kt-datatable kt-datatable--default kt-datatable--loaded kt-datatable--table">
		<table class="kt-datatable__table">
			<thead class="kt-datatable__head">
				<tr class="kt-datatable__row">
					<th class="kt-datatable__cell" v-for="column in columns" :key="column.name">
						<b>{{ column.name }}</b>
					</th>
				</tr>
			</thead>
			<tbody class="kt-datatable__body">
                <slot name="beforeRows" v-bind="scopeProps"></slot>
				<tr class="kt-datatable__row"  v-for="row in flatennedRows" :key="row.ID">
					<td v-for="column in columns" :key="column.key" class="kt-datatable__cell">
						<slot :name="column.key" v-bind="{row, ...scopeProps}"></slot>
					</td>
				</tr>
			</tbody> 
		</table>
	</div>
</template>

<script> 


export default {
	
	props: {
		isHideHead: Boolean,
		rows: Array,
		columns: Array
	},

	data: function ()
	{
		return {
			scopeProps: {
				toggleRow: this.toggleRow
			}
		};
	},

	computed: {
		flatennedRows()
		{
			return this.flattenRows(this.rows);
		}
	},

	methods: {

		initRows(rows)
		{
			rows.forEach(row => this.$set(row, 'IS_EXPAND', false));
			
			rows.filter((row) => (row.CHILDREN || []).length)
				.forEach((row) => this.initRows(row.CHILDREN));
		},


		flattenRows(rows)
		{
			return rows.reduce((flatennedRows , row) => {
				return flatennedRows.concat([
					row,
					...((row.CHILDREN || []).length > 0 && row.IS_EXPAND ? this.flattenRows(row.CHILDREN) : [])
				]);
			}, []);
		},

		toggleRow(row)
		{
			row.IS_EXPAND = !row.IS_EXPAND;
		}
	},

	mounted()
	{
		this.initRows(this.rows);
	}
}
</script>
