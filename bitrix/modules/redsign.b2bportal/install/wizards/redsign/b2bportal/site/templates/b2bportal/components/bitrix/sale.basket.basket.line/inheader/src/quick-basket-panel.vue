<template>
	<div class="kt-offcanvas-panel kt-offcanvas-panel--cart" :class="{'kt-offcanvas-panel--on': isShowed}">
		<div class="kt-offcanvas-panel__nav">
			<quick-basket-select />
			<button class="kt-offcanvas-panel__close" @click="hide"><i class="flaticon2-delete"></i></button>
		</div>

		<div class="kt-offcanvas-panel__body">
			<quick-basket-items 
				:isShowed="isShowed"
				:pathToBasket="pathToBasket" 
				:pathToOrder="pathToOrder"
				:signedParameters="signedParameters"
				@refreshed="isBlocked = false"
				ref="items"
			/>
		</div>
	</div>

</template>

<script>
import QuickBasketSelect from './quick-basket-select.vue';
import QuickBasketItems from './quick-basket-items.vue';

const { store } = B2BPortal;

export default {

	name: 'QuickBasketPanel',

	store,

	components: {
		QuickBasketSelect,
		QuickBasketItems
	},

	props: {
		pathToBasket: {
			type: String,
			default: ''
		},
		pathToOrder: {
			type: String,
			default: ''
		},
		signedParameters: {
			type: String,
			default: ''
		},
	},
	
	data() 
	{ 
		return {
			isShowed: false,
			needRefresh: false,
			isBlocked: false
		};
	},

	mounted()
	{
		this.overlay = KTUtil.insertAfter(document.createElement('div'), this.$el);
		this.overlay.classList.add('d-none');
		this.overlay.classList.add('kt-offcanvas-panel-overlay');
		this.overlay.addEventListener('click', () => this.hide());

		this.unsubscribe = this.$store.subscribeAction((action, state) => {
			if (action.type === 'multicart/select' || action.type === 'cart/fetch')
				this.isBlocked = true;
		});

		this.keyDownHandler = ({ key }) => {
			if (this.isShowed && key === 'Escape')
				this.isShowed = false;
		}; 
		document.addEventListener('keydown', this.keyDownHandler);
	},

	beforeDestroy()
	{
		document.removeEventListener('keydown', this.keyDownHandler);
		this.overlay.remove();
		this.unsubscribe();
	},

	methods: {
		show()
		{
			this.isShowed = true;
		},
		hide()
		{
			this.isShowed = false;
		},
		refresh()
		{
			this.isBlocked = true;
			this.needRefresh = false;
			// this.$refs.items.refresh()
			// 	.finally(() => this.isBlocked = false);
		}
	},

	watch: {
		isShowed(val)
		{
			if (val)
			{
				this.overlay.classList.remove('d-none');
				this.overlay.classList.add('d-block');

				// if (this.needRefresh)
				// {
				// 	this.refresh();
				// }
			}
			else
			{
				this.overlay.classList.remove('d-block');
				this.overlay.classList.add('d-none');
			}
		},
		isBlocked(val)
		{
			if (val)
			{
				KTApp.block(this.$el);
			}
			else
			{
				KTApp.unblock(this.$el);
			}
		}
	}
}
</script>