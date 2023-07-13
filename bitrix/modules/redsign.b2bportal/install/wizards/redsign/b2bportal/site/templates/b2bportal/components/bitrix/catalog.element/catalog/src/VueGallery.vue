<template>
	<div class="product-images">
		<template v-if="items.length">
			<div class="product-images-canvas mb-4" v-if="activeItem.type === 'image'">
				<img
					class="img-fluid product-images-main"
					:src="activeItem.src"
					@click="openPhotoSwipe(activeIndex)"
					
				>
			</div>
			<div class="embed-responsive embed-responsive-4by3 mb-4" v-if="activeItem.type === 'iframe_video'">
				<iframe :src="activeItem.src" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
			<div class="embed-responsive embed-responsive-4by3 mb-4" v-if="activeItem.type === 'video'">
				<video autoplay="true" muted="false" controls>
					<source :src="activeItem.src">
				</video>
			</div>
			
			
			<div class="product-images-thumbs" v-if="items.length > 1">
				<button
					v-for="(item, index) in items"
					:key="index"
					class="product-images-thumb"
					:class="{'active': activeIndex === index }"
					:style="{'background-image': 'url( ' + item.thumbnail + ')' }"
					@click="activate(index)"
				>
					<span 
						v-if="item.type === 'video' || item.type === 'iframe_video'"
						class="product-images-thumb-video"
					>
						<span class="product-images-thumb-video-icon">
							<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M8 5v14l11-7z"/></svg>
						</span>
					</span>
				</button>
			</div>
		</template>
	</div>
</template>

<script>
import VuePhotoSwipe from './VuePhotoSwipe.vue';
import { parseHashVars } from './utils';

export default {
	props: {
		startIndex: {
			type: Number,
			default: 0
		},
		items: {
			type: Array,
			default: () => []
		}
	},

	data()
	{
		return {
			activeIndex: this.startIndex
		}
	},

	computed: {
		activeItem()
		{
			return this.items[this.activeIndex] || this.items[0];
		},
		photoSwipeItems()
		{
			return this.items
				.map(item => {
					switch(item.type)
					{
						case 'iframe_video':
							return {
								html: `
									<div class="pswp-video-wrapper">
										<div class="embed-responsive embed-responsive-4by3">
											<iframe src="${item.src}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
										</div>
									</div>
								`
							};
						case 'video':
							return {
								html: `
									<div class="pswp-video-wrapper">
										<div class="embed-responsive embed-responsive-4by3">
											<video autoplay="true" muted="false" controls>
												<source src="${item.src}">
											</video>
										</div>
									</div>
								`
							};
						case 'image':
							return { ...item };
					}

					return false
				})
				.filter(item => !!item);
		}
	},

	mounted()
	{
		const hashParams = parseHashVars();
		if (hashParams.gid && hashParams.gid == this._uid)
		{
			const pid = parseInt(hashParams.pid, 10) - 1;

			this.$nextTick(() => {
				this.openPhotoSwipe(pid);
			});
		}
	},

	methods: {

		activate(index)
		{
			if (index === this.activeIndex)
				this.openPhotoSwipe(index);

			this.activeIndex = index;
		},

		openPhotoSwipe(index)
		{
			const container = document.createElement('div');
			document.body.appendChild(container);

			const vuePhotoSwipe = new (Vue.extend(VuePhotoSwipe))({
				propsData: {
					index,
					galleryUID: this._uid,
					items: this.photoSwipeItems
				}
			});

			vuePhotoSwipe.$mount(container);

			vuePhotoSwipe.$on('close', () => {
				vuePhotoSwipe.$destroy();
				vuePhotoSwipe.$el.remove();
			});
		}
	}
}
</script>