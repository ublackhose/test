<template>
	<div class="product-item-button-container" :class="{'pt-4': quantityInCart}">
		<button
			ref="buttonAdd2basket"
			class="btn btn-primary btn-sm"
			:class="{ disabled: !canBuy }"
			@click="buy"
		>
			<i class="flaticon2-shopping-cart-1 pr-0"></i>
		</button>
		<div v-if="quantityInCart" class="m-1 small text-nowrap">{{ quantityInCartMess }}</div> 
	</div>
</template>

<script>
import FieldMixin from './FieldMixin.js'; 

export default { 

	mixins: [FieldMixin],

	props: {
		quantity: {
			type: [ Number, String ],
			default: 1
		}
	},

	computed: {

		eventBus()
		{
			return this.$root.$eventBus || this;
		},

		inStock()
		{
			return parseFloat(this.product.inStock, 10);
		},

		isEnoughInstock() 
		{
			return !this.product.checkQuantity ||
				!(this.product.checkQuantity && this.quantity > this.inStock);
		},

		canBuy()
		{
			return (this.product.canBuy && this.isEnoughInstock);
		},

		quantityInCart()
		{
			return this.$store.state.cart.quantityByIds[this.product.id] || 0;
		},

		quantityInCartMess()
		{
			return BX.message('RS_B2B_CS_QUANTITY_IN_CART')
				.replace('#QUANTITY#', this.quantityInCart)
				.replace('#MEASURE#', this.product.measure);
		}
	},

	methods: {

		buy()
		{
			if (this.canBuy)
			{
				this.eventBus.$emit('buy', {
					product: this.product.id,
					quantity: this.quantity
				});
			}
		}

	}
}
</script>