<template>
	<div class="catalog-section">
		<div class="catalog-showcase">
			<CatalogItem :item="item" v-for="(item, index) in items" :key="index" />
		</div>
		<div class="catalog-pagination">
			<VuexPagination :namespace="namespace" />
		</div>
	</div>
</template>

<script>
import CatalogItem from './CatalogItem.vue';

export default {
	name: 'CatalogSection',
	components: { 
		CatalogItem, 
		VuexPagination: B2BPortal.Vue.Components.VuexPagination
	},
	props: {
		namespace: {
			type: String
		}
	},
	computed: {
		...Vuex.mapState({
			items(state) 
			{ 
				return state[this.namespace].items; 
			},
			fetching(state)
			{
				return state[this.namespace].fetching;
			}
		})
	},
	watch: {
		fetching()
		{
			if (this.fetching)
			{
				KTApp.block(this.$el);
			}
			else
			{
				KTApp.unblock(this.$el);

				this.$nextTick(() => {
					this.$el.scrollIntoView({ behavior: 'smooth' })
				});
			}
		}
	}
}
</script>