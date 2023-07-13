<template>
	<vue-table
		mode="remote"
		:columns="columns"
		:rows="rows"
		:pagination-options="{
			enabled: pagination.pageCount > 1,
			hideRowCount: true,
			setCurrentPage: pagination.currentPage,
			perPage: pagination.perPage,
			perPageDropdown: false,
		}"
		:sort-options="{
			enabled: false
		}"
		@on-page-change="handlePageChange"
		:totalRows="pagination.totalRecords"
	>
		<template slot="table-row" slot-scope="props">
			<template v-if="props.column.field === 'name'">
				<a :href="props.row.editUrl" target="_blank">{{ props.row.name }}</a>
			</template>
			<template v-else-if="props.column.field === 'total'">
				{{ props.row.products.length }} {{ totalDeclension(props.row.products.length) }}
				<div class="text-nowrap">
					{{ messages.RS_KP_KOL_T_TOTAL_VALUE }} <span v-html="props.row.totalPriceFormatted"></span>
				</div>
			</template>
			<template v-else-if="props.column.field === 'actions'">
				<div class="text-nowrap">
					<a 
						class="p-3" 
						:href="props.row.downloadUrl" 
						target="_blank"
						:title="messages.RS_KP_KOL_T_DOWNLOAD"
					>
						<i class="flaticon-download-1" aria-hidden="true"></i>
					</a>
					<a 
						class="p-3" 
						:href="props.row.editUrl"
						:title="messages.RS_KP_KOL_T_EDIT"
					>
						<i class="flaticon2-edit" aria-hidden="true"></i>
					</a>
					<a 
						class="p-3"  
						@click.prevent="deleteRow(props.row)" 
						href="#" 
						:title="messages.RS_KP_KOL_T_DELETE"
					>
						<i class="flaticon2-rubbish-bin-delete-button" aria-hidden="true"></i>
					</a>
				</div>
			</template>
			<template v-else>
				{{ props.row[props.column.field] }} 
			</template>
		</template>
	</vue-table>
</template>
<script>

const { store } = B2BPortal;

export default {
	name: 'VueKPTable',
	components: {
		'vue-table': B2BPortal.Vue.Components.VueTable
	},
	props: {
		namespace: String,
		columns: Array
	},

	computed: {

		rows()
		{
			return store.state[this.namespace].items;
		},

		pagination()
		{
			return store.state[this.namespace].pagination;
		},

		fetching()
		{
			return store.state[this.namespace].fetching;
		},

		messages()
		{
			return Object.freeze({
				RS_KP_KOL_T_TOTAL_VALUE: BX.message('RS_KP_KOL_T_TOTAL_VALUE'),
				RS_KP_KOL_T_TOTAL_PRODUCT_ONE: BX.message('RS_KP_KOL_T_TOTAL_PRODUCT_ONE'),
				RS_KP_KOL_T_TOTAL_PRODUCT_FOUR: BX.message('RS_KP_KOL_T_TOTAL_PRODUCT_FOUR'),
				RS_KP_KOL_T_TOTAL_PRODUCT_FIVE: BX.message('RS_KP_KOL_T_TOTAL_PRODUCT_FIVE'),
				RS_KP_KOL_T_DOWNLOAD: BX.message('RS_KP_KOL_T_DOWNLOAD'),
				RS_KP_KOL_T_EDIT: BX.message('RS_KP_KOL_T_EDIT'),
				RS_KP_KOL_T_DELETE: BX.message('RS_KP_KOL_T_DELETE'),
				RS_KP_KOL_T_DELETE_CONFIRM: BX.message('RS_KP_KOL_T_DELETE_CONFIRM'),
				RS_KP_KOL_T_DELETE_CONFIRM_YES: BX.message('RS_KP_KOL_T_DELETE_CONFIRM_YES'),
				RS_KP_KOL_T_DELETE_CONFIRM_NO: BX.message('RS_KP_KOL_T_DELETE_CONFIRM_NO')
			});
		},
	},

	methods: {
		handlePageChange({ currentPage })
		{	
			store.dispatch(`${this.namespace}/setPage`, currentPage);
		},
		deleteRow(row)
		{
			Swal.fire({
				title: this.messages['RS_KP_KOL_T_DELETE_CONFIRM'],
				type: 'warning',
				showCancelButton: true,
				animation: false,
				confirmButtonText: this.messages['RS_KP_KOL_T_DELETE_CONFIRM_YES'],
				cancelButtonText:  this.messages['RS_KP_KOL_T_DELETE_CONFIRM_NO'],
			})
			.then((result) => {
				if (result.value)
					this.$emit('delete', row.id);
			})
		},
		totalDeclension(n)
		{
			return [
				this.messages.RS_KP_KOL_T_TOTAL_PRODUCT_ONE,
				this.messages.RS_KP_KOL_T_TOTAL_PRODUCT_FOUR,
				this.messages.RS_KP_KOL_T_TOTAL_PRODUCT_FIVE
			][
				 (n %= 100, 20 > n && n > 4) ? 2
					:[2,0,1,1,1,2][ (n %= 10, n < 5) ? n : 5]
			];
		},
	},

	watch: {
		fetching(val)
		{
			if (val)
			{
				KTApp.block(this.$el);
			}
			else
			{
				KTApp.unblock(this.$el);
			}
		}
	}
}
</script>