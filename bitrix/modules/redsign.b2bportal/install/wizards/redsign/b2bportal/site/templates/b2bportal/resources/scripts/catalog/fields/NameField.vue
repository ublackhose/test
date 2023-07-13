<template>
	<div>
		<div class="mb-2">
			<span class="mr-2">
				<a v-if="row.url" :href="row.url">{{ name }}</a>
				<span v-else>{{ name }}</span>  
			</span>
		</div>
		<div v-if="vendorCode">
			<span class="mr-2">{{ vendorCode }}</span>
		</div>
		<div v-if="brand">
			<span class="mr-2" v-html="brand"></span>
		</div>
	</div>
</template>

<script>
import FieldMixin from './FieldMixin.js'; 

export default {
	mixins: [FieldMixin],

	computed: {

		name()
		{
			return (
				typeof(this.product.name) == 'String' && this.product.name.length > 0 ?
					this.product.name : this.row.name
			);
		},

		vendorCode()
		{
			const vendorCode = [this.product.vendorCode, this.row.vendorCode].find(code => code && code !== '');
			return vendorCode ? BX.message('RS.B2BPORTAL.TABLE.COLS.ARTICLE').replace('#NUMBER#', vendorCode) : false;
		},

		brand()
		{
			return this.row.brand !== '' ? 
				BX.message('RS.B2BPORTAL.TABLE.COLS.BRAND').replace('#BRAND#', this.row.brand)  : false;
		}
		
	}
}
</script>