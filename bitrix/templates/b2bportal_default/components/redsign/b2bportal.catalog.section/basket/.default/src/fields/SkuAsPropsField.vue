<template>
	<div>
		<div v-for="prop in formattedProps">
			<span class="mr-2"><b>{{ prop.name }}</b>: <span v-html="prop.value"></span></span>
		</div>
	</div>
</template>

<script>
import FieldMixin from './FieldMixin.js'; 

export default {
	mixins: [FieldMixin],

	computed: {

		skuProps() 
		{
			return this.$store.getters[`${this.$root.$namespace}/getSkuPropsByIblockId`](this.row.iblockId);
		},

		tree()
		{
			return this.product.tree;
		},

		formattedProps()
		{
			return Object.keys(this.tree)
				.map(key => {
					const prop = this.skuProps.find(prop => prop.ID == key.substring('PROP_'.length));

					const name = prop.NAME;
					const value = (prop.VALUES[this.tree[key]] || {}).NAME;
					
					return { name, value };
				});
		},
	}
}
</script>