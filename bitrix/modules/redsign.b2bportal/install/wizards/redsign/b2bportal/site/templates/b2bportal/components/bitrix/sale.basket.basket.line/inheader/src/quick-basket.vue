<template>
	<div class="quickbasket">
		<div class="btn-group flex-nowrap"> 
			<a :href="pathToBasket" class="btn btn-primary d-flex">
				<span>
					<i class="flaticon2-shopping-cart-1" :class="{invisible: status == 'fetching'}"></i> 
					<span 
						v-if="status == 'fetching'"
						class="kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light" 
						style="
							position: absolute;
							top: 50%;
							margin-left: -5px;
						"
					></span>
				</span> 
				<span class="text-nowrap" v-if="totalPriceRaw > 0" v-html="totalPrice"></span> 
				<span class="text-nowrap" v-else>{{ messages.RS_B2B_SBBL_BASKET_EMPTY }}</span>
			</a>
			<button v-if="panel" type="button" href="#" class="btn btn-primary btn-icon" @click.prevent="showPanel">
				<i class="flaticon2-left-arrow"></i>
			</button>
		</div>
	</div>
</template>

<script>
import VueQuickBasketPanel from './quick-basket-panel.vue';

const { store } = B2BPortal;

export default {
	name: 'QuickBasket',
	store,
	props: {
		signedParameters: {
			type: String,
			default: ''
		},
		pathToBasket: {
			type: String,
			default: ''
		},
		pathToOrder: {
			type: String,
			default: ''
		},
		panel: {
			type: Boolean,
			default: true
		}
	},
	
	computed: {
		...Vuex.mapState({
			status: state => state.cart.status,
			totalPrice: state => state.cart.totalPrice,
			totalPriceRaw: state => state.cart.totalPriceRaw,
			numProducts: state => state.cart.numProducts
		}),

		messages()
		{
			return Object.freeze({
				RS_B2B_SBBL_BASKET_EMPTY: BX.message('RS_B2B_SBBL_BASKET_EMPTY')
			});
		}
	},

	destroyed()
	{
		if (this.$panel)
			this.$panel.remove();
	},

	methods: {
		showPanel()
		{
			if (!this.$panel)
			{
				this.$panel = new (Vue.extend(VueQuickBasketPanel))({
					propsData: {
						pathToBasket: this.pathToBasket,
						pathToOrder: this.pathToOrder,
						signedParameters: this.signedParameters
					}
				});
				const container = document.createElement('div');
				document.body.appendChild(container);
				this.$panel.$mount(container);
			}

			setTimeout(() => {
				this.$panel.show();
			});
		}
	}
}
</script>

<style lang="scss" scoped>
.quickbasket {
	.btn-icon > i {
		font-size: 12px;
	}
}

</style>