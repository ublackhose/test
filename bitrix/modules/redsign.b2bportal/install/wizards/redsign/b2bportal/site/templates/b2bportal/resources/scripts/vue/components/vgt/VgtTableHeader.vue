<template>
	<thead>
		<tr>
			<th v-if="lineNumbers" class="line-numbers"></th>
			<th v-if="selectable" class="vgt-checkbox-col">
				<label class="vgt-checkbox-label kt-checkbox kt-checkbox--single kt-checkbox--solid">
					<input
						type="checkbox"
						:checked="allSelected"
						:indeterminate.prop="allSelectedIndeterminate"
						@change="toggleSelectAll" />
					<span></span>
				</label>
			</th>
			<th
				v-for="(column, index) in columns"
				:key="index"
				@click="sort($event, column)"
				:class="getHeaderClasses(column, index)"
				:style="columnStyles[index]"
				v-if="!column.hidden">
				<slot name="table-column" :column="column">
					<span>{{column.label}}</span>
				</slot>
			</th>
		</tr>
		<tr
			is="vgt-filter-row"
			ref="filter-row"
			@filter-changed="filterRows"
			:global-search-enabled="searchEnabled"
			:line-numbers="lineNumbers"
			:selectable="selectable"
			:columns="columns"
			:mode="mode"
			:typed-columns="typedColumns">
		</tr>
	</thead>
</template>

<script>
import assign from 'lodash.assign';
import VgtTableHeader from 'vue-good-table/src/components/VgtTableHeader.vue';

export default {

	extends: VgtTableHeader,

	name: 'vgt-table-header',

	methods: {

		setInitialSort(sorts)
		{
			this.sorts = sorts;
			// this.$emit('on-sort-change', this.sorts);
		},

		getHeaderClasses(column, index)
		{
			const classes = assign(
				{'text-nowrap': true},
				this.getClasses(index, 'th'),
				{
					'can-sorting': this.isSortableColumn(column) === true,
					'sorting sorting-desc': this.getColumnSort(column) === 'desc',
					'sorting sorting-asc': this.getColumnSort(column) === 'asc',
				}
			);

			return classes;
		}

	},

	components: {
		'vgt-table-header': VgtTableHeader,
	},

};
</script>
