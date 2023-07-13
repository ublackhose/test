<template>
	<VuePagination 
		:page="currentPage" 
		:pageCount="pageCount"
		:perPage="perPage"
		:perPageOptions="perPageOptions"
		:paramName="paramName"

		@page-changed="onPageChangedHandle"
		@per-page-changed="onPerPageChangedHandle"
	/>
</template>

<script>
import VuePagination from './pagination.vue';

export default {
	components: { VuePagination },
	props: {
		namespace: {
			type: String
		}
	},
	computed: {
		...Vuex.mapState({

			currentPage(state) 
			{
				return state[this.namespace].pagination.currentPage; 
			},

			pageCount(state) 
			{
				return state[this.namespace].pagination.pageCount; 	
			},

			perPage(state)
			{
				return state[this.namespace].pagination.perPage; 
			},

			perPageOptions(state)
			{
				return state[this.namespace].pagination.perPageOptions;
			},

			paramName(state)
			{
				return state[this.namespace].pagination.paramName;
			}

		})
	},
	methods: {
		onPageChangedHandle({ currentPage })
		{
			this.$store.dispatch(`${this.namespace}/setPage`, currentPage);
		},
		onPerPageChangedHandle({ perPage })
		{
			this.$store.dispatch(`${this.namespace}/setPerPage`, perPage);
		}
	}
}
</script>