<template>
	<vue-quantity :quantity="quantity" :measure="measure" /> 
</template>

<script>
import FieldMixin from './FieldMixin.js';

export default { 

	components: {
		'vue-quantity': B2BPortal.Vue.Components.Quantity
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
		}
	}
}
</script>