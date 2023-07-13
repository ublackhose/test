<template>
	<vue-stock-quantity
		:displayMode="displayMode"
		:quantity="quantity"
		:measure="measure"
		:productId="product.id"
		:useStocks="useStocks"
		:displayStocks="displayStocks"
		:relativeQuantityFactor="relativeQuantityFactor"
		:maxQuantity="maxQuantity"
		:mess="mess"
	/>
</template>

<script>
import FieldMixin from './FieldMixin.js';

export default {

	components: {
		'vue-stock-quantity': B2BPortal.Vue.Components.StockQuantity
	},

	mixins: [FieldMixin],

	computed: {

		quantity()
		{
			return Number(this.product.inStock);
		},

		measure()
		{
			return this.product.measure;
		},

		displayMode()
		{
			return this.$root.params.arParams['QUANTITY_DISPLAY_MODE'];
		},

		useStocks()
		{
			return this.$root.params.arParams['USE_STORE'];
		},

		displayStocks()
		{
			return this.$root.params.arParams['STORES'];
		},

		relativeQuantityFactor()
		{
			return this.$root.params.arParams['RELATIVE_QUANTITY_FACTOR'];
		},

		maxQuantity()
		{
			return this.$root.params.arParams['MAX_QUANTITY'];
		},

		mess()
		{
			return {
				'RELATIVE_QUANTITY_MANY': this.$root.params.arParams['MESS_RELATIVE_QUANTITY_MANY'],
				'RELATIVE_QUANTITY_FEW': this.$root.params.arParams['MESS_RELATIVE_QUANTITY_FEW'],
				'RELATIVE_QUANTITY_NO': this.$root.params.arParams['MESS_RELATIVE_QUANTITY_NO']
			};
		}
	}
}
</script>