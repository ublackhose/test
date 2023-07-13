<template>
	<div class="btn-group">
		<a :href="basketUrl" class="btn btn-primary btn-vbasket text-nowrap" :class="selectedColorClass" :title="selectedBasket.NAME">
			<i class="flaticon2-shopping-cart-1 btn-vbasket__icon"></i> <span class="btn-vbasket__name">{{ selectedBasket.NAME }} </span>
			<span  class="kt-badge kt-badge--primary ml-2 btn-vbasket__badge" v-if="selectedBasket.CNT">{{selectedBasket.CNT}}</span>
		</a>
		<template v-if="baskets.length > 0">
			<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" :class="selectedColorClass" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			</button>
			<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
				<a
					v-for="basket in baskets"
					:key="basket.ID"
					class="dropdown-item"
					@click="onClick(basket.CODE)"
				>
					{{ basket.NAME }} 
					<span class="kt-badge kt-badge--primary ml-2" v-if="basket.CNT" :style="{background: basket.COLOR}">{{ basket.CNT }}</span>
				</a>
			</div>
		</template>
	</div>
</template>

<script>
export default {

	props: {
		basketUrl: String
	},

	computed: {

		selectedBasket()
		{
			return this.$store.getters.selectedBasket;
		},

		baskets()
		{
			return this.$store.getters.notSelectedBaskets;
		},

		selectedColorClass()
		{
			return this.getColorClass(this.selectedBasket);
		},

	},

	methods: {

		getColorClass(basket)
		{
			return basket.COLOR ? 'btn-colored--' + basket.COLOR.toLowerCase().replace('#', '') : '';
		},

		onClick(code)
		{
			KTApp.blockPage();
			this.$store.dispatch('selectBasket', code);
		},

	}

}
</script>
<style scoped>
.btn-vbasket {}
.btn-vbasket__name {
	display: inline-block;
	vertical-align: middle;
	max-width: 88px;
	overflow: hidden;
	text-overflow: ellipsis;
}
.kt-badge.btn-vbasket__badge {
	background-color: #fff; 
	color: #000;
}
</style> 