<template>
	<div class="product-amount form-inline d-inline-block mw-100" data-entity="quantity-block">
		<div class="form-group form-group-last justify-content-center">
			<VueQuantityInput
				:min="ratio"
				:max="(product.checkQuantity ? Number(product.inStock) : 999999)"
				:step="ratio"
				:is-invalid="!isEnoughInstock"
				v-model="quantity"
				@change="checkQuantity"
			/>
		</div>
	</div>
</template>

<script>
import FieldMixin from './FieldMixin.js';

export default {

	mixins: [FieldMixin],

	components: {
		'VueQuantityInput': B2BPortal.Vue.Components.QuantityInput
	},

	props: {
		value: {
			type: Number | String,
			default: 1
		},
	},

	data()
	{
		return {
			quantity: parseFloat(this.product.ratio, 10)
		};
	},

	mounted()
	{
		this.eventBus.$on('clearQuantity', itemId => {
			if (itemId == this.product.id)
				this.quantity = this.product.ratio;
		});
	},

	methods: {

		checkQuantity()
		{
			if(!Number.isFinite(this.quantity))
			{
				this.quantity = this.product.ratio;
			}
			else
			{
				let newQuantity = this.quantity >= this.product.inStock ? Number(this.product.inStock) : this.quantity;
				const intCount = Math.floor(Math.round(newQuantity * 10000000 / this.ratio) / 10000000) || 1;
				newQuantity = (intCount <= 1 ? this.ratio : intCount * this.ratio);
				newQuantity = Math.round((newQuantity + Number.EPSILON) * 100) / 100;

				if (newQuantity <= this.ratio)
					this.quantity = this.ratio;
				else
					this.quantity = newQuantity;
			}
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

		ratio()
		{
			return Number(this.product.ratio);
		}
	},

	watch: {

		product()
		{
			this.checkQuantity();
		},

		quantity()
		{
			this.$emit('input', this.quantity);
		}

	}
}
</script>