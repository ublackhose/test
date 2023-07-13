import VueGallery from './VueGallery.vue';
import './_style.scss';

export class CatalogElement
{
	constructor(data = {})
	{
		this.blockIds = data.blockIds;
		this.gallery = data.gallery;

		this.attachGallery()
	}

	attachGallery()
	{
		const el = document.getElementById(this.blockIds.gallery);
		const items = (this.gallery || {}).items;

		this.$gallery = new Vue({
			el,
			components: { VueGallery },
			data() { return { items } },
			template: `<VueGallery :items="items" />`,
		});
	}

}
