<template>
	<div>
		<div class="d-flex">
			<div
				class="mr-3 mt-2"
				:class="{
					'product-preview-picture-40': view === 'sku',
					'product-preview-picture-60': view !== 'sku',
				}"
				v-if="usePreviewPicture"
			>
				<div data-html="true" data-toggle="popover" ref="preview" v-if="preview">
					<img :src="previewThumbnail" class="img-fluid">
				</div>
				<div v-else>
					<img :src="images.noimage" class="img-fluid">
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
			</div>
		</div>
	</div>
</template>

<script>

import FieldMixin from './FieldMixin.js';
import { getProductName, getVendorCode } from '../utils';

export default {

	mixins: [FieldMixin],

	props: {
		view: {
			type: String,
			default: 'default'
		},
		useImageFromGroupingItem: {
			type: Boolean,
			default: true
		}
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
			return (this.product.preview || {}).SRC || (this.useImageFromGroupingItem ? (this.row.preview || {}).SRC : '');
		},

		previewThumbnail()
		{
			return this.useImageFromGroupingItem ?
				((this.product.previewThumbnail || this.row.previewThumbnail || {}).src) || this.preview :
				this.product.previewThumbnail || this.preview;
		},

		usePreviewPicture()
		{
			return this.$store.getters[`${this.$root.$namespace}/isShowPreview`];
		},

		labels()
		{
			return this.row.labels;
		},

		images()
		{
			return ((this.$root.params || {}).imagesPath) || {};
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
.product-preview-picture-40,
.product-preview-picture-60 {
	text-align: center;
}

.product-preview-picture-60 { width: 3.75rem; }
.product-preview-picture-60 .img-fluid { max-height: 3.75rem; }

.product-preview-picture-40 { width: 2.5rem; }
.product-preview-picture-40 .img-fluid { max-height: 2.5rem; }
</style>