export default {

	props: {
		row: Object  
	},

	computed: {

		product()
		{
			return this.row.products[this.row.selected] || 1;
		},
		
		eventBus()
		{
			return (this.$root.eventBus || this);
		},

		quantity()
		{
			return parseFloat(this.row.quantity, 10);
		},

		inStock()
		{
			return parseFloat(this.product.inStock, 10);
		},

		isEnoughInstock() 
		{
			return !this.product.checkQuantity ||
				!(this.product.checkQuantity && this.quantity > this.inStock);
		}
	}

}  