<template>
	<vue-table
		:isLoading="isLoading"
		:mode="mode"
		:columns="columns"
		:rows="preparedRows"
		:totalRows="totalRows"
		:selectOptions="selectOptions"
		:paginationOptions="paginationOptions"
		:sortOptions="sortParams"
		@on-page-change="onPageChange"
		@on-per-page-change="onPerPageChange"
		@on-sort-change="onChangeSort"
		@on-selected-rows-change="selectionChanged"
	>

		<template slot="table-row" slot-scope="props">
			<template v-if="props.column.field == 'NAME'">
				<a
					:href="props.row.detail_page_url"
					v-html="props.row.NAME"
				></a>
			</template>
			<template v-else-if="props.column.field == 'actions'">
				<div class="dropdown position-static">
					<a data-toggle="dropdown" role="button" href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" aria-expanded="false"><i class="la la-ellipsis-h"></i></a>
					<div class="dropdown-menu dropdown-menu-right">
						<ul class="kt-nav">
							<li class="kt-nav__item">
								<a :href="props.row.delete_page_url" class="kt-nav__link">
									<i class="kt-nav__link-icon flaticon2-trash"></i>
									<span class="kt-nav__link-text">{{ messages.REMOVE }}</span>
								</a>
							</li>
							<li class="kt-nav__item">
								<a :href="props.row.copy_page_url" class="kt-nav__link">
									<i class="kt-nav__link-icon flaticon2-copy"></i>
									<span class="kt-nav__link-text">{{ messages.COPY }}</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</template>
			<template v-else>
				{{ props.formattedRow[props.column.field] }}
			</template>
		</template>

	</vue-table>
</template>

<script>
export default {

	name: 'vue-profile-list-table',

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

	computed: {
		
		preparedRows()
		{
			return this.rows.map(item => {
				item.delete_page_url = item.delete_page_url.replace('&amp;', '&')
				item.copy_page_url = item.copy_page_url.replace('&amp;', '&')
				return item
			})
		},

		messages()
		{
			return Object.freeze({
				'REMOVE': BX.message('RS_B2BPORTAL_SPPL_ACTIONS_REMOVE'),
				'COPY': BX.message('RS_B2BPORTAL_SPPL_ACTIONS_COPY'),
			})
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

	},

	components: {
		'vue-table': B2BPortal.Vue.Components.VueTable
	},

}
</script>
