<template>
	<div class="kt-section d-flex flex-wrap">
		<div class="d-inline-block my-2 mr-2" v-for="(item, index) in data" :key="index">
			<div class="btn-group btn-basket-group" :class="{'btn-basket-group--active': item.SELECTED}" :style="{color: item.COLOR}">
				<a class="btn" href="#"  @click.prevent="select(item.CODE)">
					<span class="btn-basket-text">
						{{ item.NAME }} 
						<span class="kt-badge kt-badge--primary ml-2" v-if="item.CNT" :style="{background: item.COLOR}">{{ item.CNT }}</span>
					</span>
				</a>
				<a v-if="useSharing && item.SELECTED && item.CNT" class="btn btn-basket-icon"  href="#" @click.prevent="share(item)"><i class="la la-link pr-0"></i></a>
				<a v-if="item.SELECTED" class="btn btn-basket-icon"  href="#" @click.prevent="edit(item)"><i class="la la-pencil pr-0"></i></a>
				<a v-if="item.SELECTED && data.length > 1" class="btn btn-basket-icon"  href="#" @click.prevent="remove(item.CODE)"><i class="la la-remove pr-0"></i></a>
			</div>
		</div>
		<div class="d-inline-block my-2 ml-2">
			<a class="btn text-secondary" href="#" @click.prevent="add()"><i class="flaticon2-plus pr-0"></i></a>
		</div>

		<div class="modal fade" style="display: none;" aria-hidden="true" ref="modal">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">{{ modal.title }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<input type="new_cart_name" class="form-control" :placeholder="messages.RS_B2BPORTAL_BS_BASKET" v-model="editable.name" ref="nameInput" @keyup.enter="save">
						</div>
						<div class="form-group mb-0">
							<swatches
								v-model="editable.color" 
								popover-to="left" 
								:colors="colors" 
								swatch-size="35" 
								:wrapper-style="{ paddingRight: '0px', paddingTop: '0px', textAlign: 'center' }" 
								inline
							/>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-brand" data-dismiss="modal">{{ messages.RS_B2BPORTAL_BS_CANCEL }}</button>
						<button type="button" class="btn btn-primary" @click.prevent="save">{{ messages.RS_B2BPORTAL_BS_SAVE }}</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" style="display: none" aria-hidden="true" ref="shareModal" v-if="useSharing">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">{{ messages.RS_B2BPORTAL_BS_SHARE_MODAL_TITLE }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="form-group mb-0">
							<label>{{ messages.RS_B2BPORTAL_BS_SHARE_MODAL_LABEL }}</label>
							<div class="d-flex">
								<input type="text" class="form-control" v-model="shareLink"  ref="shareLinkInput">
								<button class="btn btn-primary ml-2" @click="copyShareLink()"> {{ messages.RS_B2BPORTAL_BS_SHARE_MODAL_COPY_LINK  }} </button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Swatches from 'vue-swatches'

	const defaultColor = '#5867dd';

	export default {

		components: { Swatches },

		props: {
			items: Array,
			useSharing: {
				type: Boolean,
				default: false
			}
		},

		data()
		{
			return {
				colors: [
					"#5867DD", "#D32F2F","#C2185B","#7B1FA2","#512DA8","#303F9F","#1976D2","#0288D1","#0097A7","#00796B",
					"#388E3C","#689F38","#AFB42B","#FBC02D","#FFA000","#F57C00","#E64A19", "#5D4037","#616161","#455A64"
				],
				modal: {
					title: '',
				},
				editable: {
					id: null,
					name: '',
					color: defaultColor
				},
				shareLink: '',
			}
		},

		computed: {
			selected()
			{
				return this.data.find((item) => item.SELECTED);
			},
			data()
			{
				return this.items.map((item) => {
					item.STYLES = this.btnStyles(item);
					return item;
				});
			},
			messages()
			{
				return (
					Object.freeze(
						Object.keys(BX.message).filter(message => message.startsWith('RS_B2BPORTAL_BS_'))
							.reduce((obj, message) => { obj[message.slice(message)] = BX.message(message); return obj; }, {})
					)
				);
			}
		},

		mounted()
		{
			$(this.$refs.modal).on('shown.bs.modal', () => {
				this.$refs.nameInput.focus();
			});
			
			$(this.$refs.modal).on('hidden.bs.modal', () => {
				this.editable = {
					id: null,
					name: '',
					color: defaultColor
				}
			});
		},

		methods: {

			btnStyles(item)
			{
				const classes = {};

				classes['btn-basket'] = true;

				return classes;
			},

			add()
			{
				this.modal.title = this.messages.RS_B2BPORTAL_BS_CREATE;
				this.editable.name = this.messages.RS_B2BPORTAL_BS_BASKET + ' #' +  (this.data.length + 1);

				$(this.$refs.modal).modal();
			},

			edit(item)
			{
				this.modal.title = this.messages.RS_B2BPORTAL_BS_UPDATE;

				this.editable.id = item.CODE;
				this.editable.name = item.NAME;
				this.editable.color = item.COLOR != '' ? item.COLOR : defaultColor;

				$(this.$refs.modal).modal();
			},

			async share(item) {

				const result = await BX.ajax.runAction('redsign:vbasket.controller.sharecontroller.getLink',
					{
						data: { code: item.CODE }
					}
				);

				if ((result.data || {}).isSuccess)
				{
					this.shareLink = result.data.link;
					$(this.$refs.shareModal).modal();
					
				}
			},

			copyShareLink()
			{
				this.$refs.shareLinkInput.select();
				this.$refs.shareLinkInput.focus();
				document.execCommand('copy');
			},

			async save()
			{
				const data = {
					code: this.editable.id,
					name: this.editable.name,
					color: this.editable.color
				};

				KTApp.block(this.$refs.modal);

				const result = await B2BPortal.store.dispatch('saveBasket', data);
				if (result && result.isSuccess)
				{
					$(this.$refs.modal).modal('hide');

					if (this.editable.id === null)
					{
						B2BPortal.store.dispatch('selectBasket', result.code);
					}
				}

				KTApp.unblock(this.$refs.modal);

			},

			async remove(code)
			{
				if (confirm(this.messages.RS_B2BPORTAL_BS_REMOVE_CONFIRM))
				{
					await B2BPortal.store.dispatch('removeBasket', code);
				}
			},

			async select(code)
			{
				await B2BPortal.store.dispatch('selectBasket', code)
			}
		}

	}
</script>

<style lang="scss" scoped>

.btn-basket-group {
	border-bottom: 1px solid #e1e1ef;
	color: #e1e1ef;

	&--active {
		border-bottom-color: currentColor;
		font-weight: bold;
	}
}


.btn-basket-text {
	color: #586272;

	.btn:hover > & {
		color: #212529;
	}
}

.btn-basket-icon {
	color: #e1e1ef;
	padding-left: 7px;
	padding-right: 7px;

	[class^="flaticon2-"] {
		font-size: 1rem;
	}

	&:hover,
	&:focus,
	&:active {
		color: currentColor;
	}
}

</style>