<template>
	<div>
		<div v-for="prop in formattedPropsValues" :key="prop.ID">
			{{ prop.NAME }}

			<ul class="sku-list">
				<li 
					v-for="value in prop.values" :key="value.ID" 
					class="sku-list__item"
					:class="{
						'sku-list__item--selected': product.tree['PROP_' + prop.ID] == value.ID,
						'sku-list__item--disabled': cantBuy(value.ID)
					}"
				>
					<div 
						v-if="prop.SHOW_MODE == 'PICT'"
						@click.prevent="select(prop.ID, value.ID)"
						class="sku-list__value sku-list__value--image"
						:title="value.NAME"
					>
						<div class="sku-list__image" :style="{backgroundImage: 'url(' + (value.PICT.SRC || images.noPropValue) + ')'}"></div>
					</div>
					<div
						v-else
						@click.prevent="select(prop.ID, value.ID)"
						class="sku-list__value sku-list__value--text"
					>
						{{ value.NAME }}
					</div>
				</li>
			</ul>
		</div>

	</div>
</template>

<script>
import findKey from 'lodash/findKey';
import findIndex from 'lodash/findIndex';
import isMatch from 'lodash/isMatch';
import reduce from 'lodash/reduce';
import map from 'lodash/map';
import flatMap from 'lodash/flatMap';
import FieldMixin from './FieldMixin';

export default {

	mixins: [FieldMixin],
	
	computed: {

		skuProps() {
			return this.$store.getters["CatalogSection/skuProps"][this.row.iblockId] || [];
		},

		treeProps()
		{
			return this.skuProps.filter(prop => this.propsValues[prop.ID]);
		},

		propsValues()
		{
			return this.row.sku;
		},

		disabledValues()
		{
			return flatMap(this.propsValues, (values, propId) => {
				return reduce(values, (result, value, valueId) => {
					if (!!!this.findProduct(propId, valueId)) result.push(propId + '_' + valueId);
					return result;
				}, []);
			});
		},

		cantBuyValues()
		{
			return flatMap(this.treeProps, prop => {
				return Object.keys(this.propsValues[prop.ID])
					.filter(valueId => !this.isDisabled(prop.ID, valueId))
					.reduce((result, valueId) => {
						if (!this.findProduct(prop.ID, valueId, true)) result.push(valueId);
						return result;
					}, []);
			});
		},

		formattedPropsValues()
		{
			return this.skuProps
				.filter(prop => this.propsValues[prop.ID])
				.map(prop => ({
					ID: prop.ID,
					NAME: prop.NAME,
					SHOW_MODE: prop.SHOW_MODE,
					values: Object.values(prop.VALUES)
						.filter(value => this.propsValues[prop.ID][value.ID] && !this.isDisabled(prop.ID, value.ID))
				}));
		},

		images()
		{
			return ((this.$root.params || {}).imagesPath) || {};
		}
	},

	methods: {

		isDisabled(propId, valueId)
		{
			return this.disabledValues.includes(propId + '_' + valueId);
		},

		cantBuy(valueId)
		{
			return this.cantBuyValues.includes(valueId);
		},

		select(propId, valueId)
		{
			if (!this.isDisabled(propId, valueId))
			{
				this.row.selected = this.findNearestProduct(propId, valueId, !this.cantBuy(valueId)) || this.row.selected;
			}
		},

		getFilter(propId, valueId, index = 0)
		{
			const filter = {};

			for (let i = 0, strPropName = ''; i < index; i++)
			{
				strPropName = 'PROP_' + this.treeProps[i].ID;
				filter[strPropName] = this.product.tree[strPropName];
			}

			filter['PROP_' + propId] = valueId;

			return filter;
		},

		findProductByFilter(filter, canBuy = false)
		{
			if (canBuy)
			{
				return findKey(this.row.products, product => isMatch(product.tree, filter) && product.canBuy);
			}
			else
			{
				return findKey(this.row.products, product => isMatch(product.tree, filter));
			}
		},

		findNearestProduct(propId, valueId, canBuy = false)
		{
			let productId = false;

			for (let i = this.treeProps.length, filter; i >= 0; i--)
			{
				productId = this.findProductByFilter(this.getFilter(propId, valueId, i), canBuy);

				if (productId)
				{
					break;
				}
			}

			return productId;
		},

		findProduct(propId, valueId, canBuy = false)
		{
			const index = findIndex(this.skuProps, prop => prop.ID == propId);
			return -1 < index ? this.findProductByFilter(this.getFilter(propId, valueId, index), canBuy) : false;
		},
	}

}
</script>

<style lang="scss" scoped>
.sku-list {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    margin: 0;
    padding: 0;

	&__item {
		display: block;
		padding: 0;
		margin: 0;
	}

	&__value {
		display: block;
		margin: 2px;
		cursor: pointer;
		padding: 1px;
		border: 1px solid #efeff5;
	}

	&__value--image {
		position: relative;
	}

	&__image {
		width: 20px;
		height: 20px;
		background-size: cover;
		background-position: center;
	}

	&__value--text {
		padding: 1px;
		border: 1px solid #efeff5 ;
		display: block;
		margin: 2px;
		font-size: 12px;
		min-width: 19px;
		height: 20px;
		color: #646c9a;
		text-align: center;
		cursor: pointer;
	}

	&__item--disabled > &__value {
		opacity: 0.65;
	}

	&__item--selected > &__value--text {
		background-color: #646c9a;
		border-color: #646c9a;
		color: #fff;
	}

	&__item--selected > &__value--image {
		border-color: #646c9a;
	}
}
</style>