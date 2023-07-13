<template>
	<div class="catalog-showcase-item" :id="item.areaId">
		<a :href="item.url" class="catalog-showcase-item__picture">
			<img :src="item.preview" :alt="item.previewAlt" :title="item.previewTitle"> 
		</a>
		<div class="catalog-showcase-item__data">
			<a :href="item.url" class="catalog-showcase-item__name">{{ item.name }}</a>
			<div class="catalog-showcase-item__price">
				<span class="small" v-if="item.priceStart">{{ mess.RS_B2B_CS_SHOWCASE_PRICE_FROM }} </span> 
				<span v-html="printPrice"></span>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: `CatalogItem`,

	props: {
		item: {
			type: Object
		}
	},

	computed: {

		...Vuex.mapState({
			iblock(state) 
			{ 
				return state[this.$root.namespace].iblock; 
			}
		}),

		mess()
		{
			return Object.freeze({
				'RS_B2B_CS_SHOWCASE_PRICE_FROM': BX.message('RS_B2B_CS_SHOWCASE_PRICE_FROM')
			});
		},

		product()
		{
			return this.item.products[this.item.selected];	
		},

		printPrice()
		{
			if (this.item.priceStart)
				return this.item.priceStart.printPrice;

			if (this.product.prices[this.product.priceSelected])
				return this.product.prices[this.product.priceSelected].printPrice;

			return '';
		}
	},

	mounted()
	{
		this.setAdminBorder();
	},

	methods: {
		setAdminBorder()
		{
			if (BX.admin && BX.admin.dynamic_mode_show_borders)
			{
				const menu = new BX.CMenuOpener({
					'parent': this.item.areaId,
					'menu': [{
						'ICONCLASS': 'bx-context-toolbar-edit-icon',
						'TITLE': '',
						'TEXT': this.iblock.messages.element_edit,
						'ONCLICK': "(new BX.CAdminDialog({'content_url': '" + this.item.menu.edit + "' })).Show()"
					}, {
						'ICONCLASS': 'bx-context-toolbar-delete-icon',
						'TITLE': '',
						'TEXT': this.iblock.messages.element_delete,
						'ONCLICK': 'if(confirm(\'Are you sure?\')) jsUtils.Redirect([], ' + this.item.menu.edit + ');'
					}]
				});

				menu.Show();

				BX.admin.setComponentBorder(this.item.areaId);
			}
		}
	}
}
</script>