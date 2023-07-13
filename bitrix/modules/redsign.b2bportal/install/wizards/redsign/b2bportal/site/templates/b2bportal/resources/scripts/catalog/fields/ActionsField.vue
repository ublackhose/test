<template>
	<div class="product-item-button-container">
		<button
			ref="buttonAdd2basket"
			class="btn btn-primary btn-sm"
			:class="{disabled: !canBuy}"
			@click="buy"
		>
			<i class="flaticon2-shopping-cart-1 pr-0"></i>
		</button>
	</div>
</template>

<script>
import FieldMixin from './FieldMixin.js';

export default { 
	mixins: [FieldMixin],

	computed: {

		canBuy()
		{
			return (this.product.canBuy && this.isEnoughInstock);
		}

	},

	methods: {

		buy()
		{
			if (this.canBuy)
			{
				
				this.eventBus.$emit('buy', {
					product: this.product.id,
					quantity: this.row.quantity
				});
			}
		}

	}
}
</script>