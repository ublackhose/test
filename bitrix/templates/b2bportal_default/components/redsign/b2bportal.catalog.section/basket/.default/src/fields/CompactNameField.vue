<template>
	<div>
		<div class="d-flex">
			<div
				class="mr-3 mt-2 product-preview-picture-60"
				v-if="usePreviewPicture"
			>
				<div data-html="true" data-toggle="popover" ref="preview" v-if="preview">
					<img :src="previewThumbnail" class="img-fluid">
				</div>
			</div>
			<div class="d-block">
				<div class="mb-2">
					<span class="mr-2">
						<a v-if="row.url" :href="row.url" v-html="name"></a>
						<span v-else v-html="name"></span>
					</span>
				</div>
				<div v-if="vendorCode">
					<span class="mr-2">{{ vendorCode }}</span>
				</div>
				<div v-if="view !== 'sku' && brand">
					<span class="mr-2" v-html="brand"></span>
				</div>
				<div class="mt-2" v-if="view !== 'sku' && labels.length">
					<span
						class="badge mr-2 mb-2"
						:class="`label-${(label.code || '').toLowerCase()} badge-${label.modifier}`"
						v-for="label in labels" :key="label.code"
						v-html="label.name"
					></span>
				</div>

				<div v-if="hasSku" class="mt-2">
					<SkuField :row="row" :product="product" :showModifications="false"></SkuField>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

import FieldMixin from './FieldMixin.js';
import SkuField from './SkuField.vue';
import { getProductName, getVendorCode } from '../utils';

export default {

	mixins: [FieldMixin],

	components: { SkuField },

	props: {
		view: {
			type: String,
			default: 'default'
		},
	},

	computed: {

		name()
		{
			return getProductName(this.row, this.product);
		},

		vendorCode()
		{
			const vendorCode = getVendorCode(this.row, this.product);
			return vendorCode ? BX.message('RS.B2BPORTAL.TABLE.COLS.ARTICLE').replace('#NUMBER#', vendorCode) : false;
		},

		brand()
		{
			return this.row.brand !== '' ?
				BX.message('RS.B2BPORTAL.TABLE.COLS.BRAND').replace('#BRAND#', this.row.brand)  : false;
		},

		hasSku()
		{
			return Object.keys(this.row.sku).length > 0;
		},

		preview()
		{
			return (this.product.preview || {}).SRC || (this.row.preview || {}).SRC;
		},

		previewThumbnail()
		{
			return ((this.product.previewThumbnail || this.row.previewThumbnail || {}).src) || this.preview;
		},

		usePreviewPicture()
		{
			return this.$store.getters[`${this.$root.$namespace}/isShowPreview`];
		},

		labels()
		{
			return this.row.labels;
		},

		hasSku()
		{
			return Object.keys(this.row.sku).length > 0;
		}

	},

	mounted()
	{
		this.initPreviewPopovers();
	},

	methods: {
		initPreviewPopovers()
		{
			if (this.usePreviewPicture)
			{
				$(this.$refs.preview).popover({
					trigger: 'hover',
					placement: 'right',
					boundary: 'window',
					html: true,
					content: () =>  `<img class="img-fluid" src="${this.preview}" />`,
					title: '',
				});

			}
		}
	},

	watch: {
		preview()
		{
			this.$nextTick(() => {
				this.initPreviewPopovers();
			});
		}
	}
}
</script>

<style scoped>
.product-preview-picture-60 { text-align: center; }
.product-preview-picture-60 { width: 3.75rem; }
.product-preview-picture-60 .img-fluid { max-height: 3.75rem; }
</style>