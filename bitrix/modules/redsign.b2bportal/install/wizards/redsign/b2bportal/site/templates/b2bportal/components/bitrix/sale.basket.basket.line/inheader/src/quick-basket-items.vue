<template>
	<div>
		<div class="p-5 d-flex align-items-center justify-content-center" v-if="!loaded">
			<div class="kt-spinner kt-spinner--lg kt-spinner--primary"></div>
		</div>
		<template v-if="loaded">
			<template v-if="readyProducts.length">
				<div class="kt-widget-17" >
					<div class="kt-widget-17__item" v-for="item in readyProducts" :key="item.id">
						<div class="kt-widget-17__product">
							<div class="kt-widget-17__thumb">
								<template v-if="item.pictureSrc">
									<a v-if="item.detailPageUrl" :href="item.detailPageUrl">
										<img :src="item.pictureSrc" class="kt-widget-17__image" alt="" title="">
									</a>
									<img v-else :src="item.pictureSrc" class="kt-widget-17__image" alt="" title="">
								</template>
							</div>
							<div class="kt-widget-17__product-desc">
								<a v-if="item.detailPageUrl" :href="item.detailPageUrl">
									<div class="kt-widget-17__title" v-html="item.name"></div>
								</a>
								<div v-else class="kt-widget-17__title" v-html="item.name"></div>
								<div class="kt-widget-17__sku" v-html="item.vendorCode"></div>
							</div>
						</div>
						<div class="kt-widget-17__prices">
							<div class="kt-widget-17__unit text-nowrap" v-html="item.priceFmt + ' <span>x</span> ' + item.quantity + ' ' + (item.measure || '')"></div>
							<div class="kt-widget-17__total" v-html="item.sumFmt"></div>
						</div>
					</div>
				</div>
				<div class="mt-5 d-flex justify-content-between">
					<a :href="pathToBasket" class="btn btn-default">{{ messages.RS_B2B_SBBL_TO_BASKET }}</a>
					<a :href="pathToOrder" class="btn btn-primary">{{ messages.RS_B2B_SBBL_TO_ORDER }}</a>
				</div>
			</template>
			<template v-else>
				<QuickBasketEmpty />
			</template>
		</template>
	</div>
</template>

<script>
import QuickBasketEmpty from './quick-basket-empty.vue';

export default {
	components: { QuickBasketEmpty },
	props: {
		isShowed: {
			type: Boolean,
			default: false
		},
		pathToBasket: {
			type: String,
			default: ''
		},
		pathToOrder: {
			type: String,
			default: ''
		},
		signedParameters: {
			type: String,
			default: ''
		}
	},
	data()
	{
		return {
			loaded: false,
			needRefresh: false,
			categories: {},
		}
	},
	created()
	{
		this.load();
		this.unsubscribe = this.$store.subscribeAction((action, state) => {
			if (action.type !== 'cart/fetch')
				return

			if (this.isShowed)
			{
				this.refresh();
			}
			else
			{
				this.needRefresh = true;
			}
		})
	},
	beforeDestroy()
	{
		this.unsubscribe();
	},
	computed: {
		messages()
		{
			return Object.freeze({
				'RS_B2B_SBBL_TO_ORDER': BX.message('RS_B2B_SBBL_TO_ORDER'),
				'RS_B2B_SBBL_TO_BASKET': BX.message('RS_B2B_SBBL_TO_BASKET'),
			});
		},
		readyProducts()
		{
			return this.categories.ready || [];
		},
	},
	methods: {
		async load()
		{
			try
			{
				const result = await new Promise((resolve, reject) => {
					const signedParameters = this.signedParameters
					const data = { c: 'sale.basket.basket.line' };
					BX.ajax.runAction('redsign:b2bportal.api.cart.getItems', { signedParameters, data })
						.then(resolve, reject)
				});

				this.loaded = true;
				this.categories = result.data;

				return result;
			}
			catch(e)
			{
				console.error(e);
			}

			return false;
		},

		refresh()
		{
			return this.load()
				.then(res => {
					this.$emit('refreshed');
					return res;
				});
		},

	},
	watch: {
		isShowed(val)
		{
			if (val && this.needRefresh)
				this.refresh();
		}
	}
}
</script>