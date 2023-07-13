<template>
	<div class="product-amount form-inline d-inline-block mw-100" data-entity="quantity-block">
		<div class="form-group justify-content-center">
			<input
				ref="input"
				type="number"
				class="product-amount-field form-control form-control-sm"
				:class="{'is-invalid': !isEnoughInstock}"
				:min="product.ratio"
				:max="product.inStock"
				:step="product.ratio"
				v-model.number="row.quantity"
				@change="checkQuantity"
			>
		</div>
	</div>
</template>

<script>
import FieldMixin from './FieldMixin';

export default {

	mixins: [FieldMixin],

	methods: {

		checkQuantity()
		{
			if (this.row.quantity == '')
			{
				this.row.quantity = this.product.ratio;
			}

			if (!this.isEnoughInstock)
			{
				this.row.quantity = this.product.inStock > 0 ? this.product.inStock : this.product.ratio;
			}
		}

	},

	watch: {

		product()
		{
			this.checkQuantity();
		}
		
	}
}
</script>

<style scoped>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
.product-amount-field {
	width: 60px;
}
</style>