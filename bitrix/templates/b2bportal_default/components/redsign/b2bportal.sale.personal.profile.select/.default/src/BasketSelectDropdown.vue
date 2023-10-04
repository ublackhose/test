<template>
	<div class="btn-group">
		<a :href="basketUrl" class="btn btn-primary text-nowrap" :class="selectedColorClass">
			<i class="flaticon2-shopping-cart-1"></i> {{ selectedBasket.NAME }} 
			<span  class="kt-badge kt-badge--primary ml-2" v-if="selectedBasket.CNT" style="background-color: #fff; color: #000;">{{selectedBasket.CNT}}</span>
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
