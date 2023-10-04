<template>
	<div>
		<span class="text-nowrap" v-html="value"></span>
		<template v-if="hasRanges()">
			<PriceRange 
				:ranges="product.quantityRanges" 
				:prices="product.prices" 
				:type="type"
				:measureTitle="product.measure"
			/>
		</template>
	</div>
</template>
<script>
import FieldMixin from './FieldMixin.js'; 
import PriceRange from '../PriceRange.vue';
import { checkQuantityRange } from '../utils';

export default {

	mixins: [FieldMixin],

	components: { PriceRange },

	props: {
		type: String,
		quantity: [ Number, String ]
	},

	computed: {

		range()
		{
			const quantity = !this.quantity ? this.product.ratio : this.quantity;
			return Object.values(this.product.quantityRanges).find(range => checkQuantityRange(range, quantity));
		},

		value()
		{
			return this.range ? this.product.prices[this.range.hash][this.type] : '';
		}

	},

	methods: {

		hasRanges()
		{
			return Object.keys(this.product.quantityRanges).length > 1;
		},

	}
	
}
</script>