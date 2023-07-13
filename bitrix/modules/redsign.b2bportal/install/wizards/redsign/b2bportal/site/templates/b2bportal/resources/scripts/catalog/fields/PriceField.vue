<template>
	<div>
		<span class="text-nowrap">{{ value }}</span>
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
import FieldMixin from './FieldMixin';
import PriceRange from '../PriceRange.vue';

export default {
	
	mixins: [FieldMixin],

	components: {
		PriceRange
	},

	props: {
		type: String
	},

	computed: {

		range()
		{
			const quantity = this.row.quantity == '' ? this.product.ratio : this.row.quantity;
			return Object.values(this.product.quantityRanges).find(range => this.checkQuantityRange(range, quantity));
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
		
		checkQuantityRange(range, quantity)
		{
			return (
				parseFloat(quantity) >= parseFloat(range.sort_from) &&
				(
					range.sort_to === 'INF' ||
					parseFloat(quantity) <= parseFloat(range.sort_to)
				)
			);	
		}

	}
	
}
</script>