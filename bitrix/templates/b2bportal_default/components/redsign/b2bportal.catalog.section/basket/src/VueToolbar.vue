<template>
	<div class="d-flex">
		<div class="btn btn-default">
			<i class="flaticon2-soft-icons"></i> {{ localize.views }}
		</div>
		<div class="dropdown position-static mr-2" v-if="isShowActions">
			<a data-toggle="dropdown" data-boundary="viewport" role="button" href="#" class="btn btn-default" aria-expanded="false">
				<i class="flaticon2-soft-icons"></i> {{ localize.actions }}
			</a> 
			<div class="dropdown-menu dropdown-menu-right"  ref="actions">
				<ul class="kt-nav kt-nav--fit-ver">
					
					<li v-if="options.previewSwitcher" class="kt-nav__section">
						<span class="kt-nav__section-text">{{ localize.settings }}</span>
					</li>

					<li v-if="options.previewSwitcher" class="kt-nav__section">
						<div class="mb-0 d-flex align-items-center justify-content-between">
							<label class="mb-0 py-0">{{ localize.switcher }}</label>
							<div class="d-block">
								<span class="kt-switch kt-switch--sm kt-switch--outline kt-switch--icon kt-switch--primary">
								<label class="mb-0">
									<input type="checkbox" :checked="previewSwitcher" @change="togglePreviewSwitcher">
									<span></span>
								</label>
								</span>
							</div>
						</div>
					</li>

					<li class="kt-nav__section" v-if="exports.length > 0">
						<span class="kt-nav__section-text">{{ localize.export }}</span>
					</li>

					<li class="kt-nav__item" v-for="({name, url}, index) in exports" :key="index">
						<a :href="url" target="_blank" class="kt-nav__link">
							<i class="kt-nav__link-icon la la-file-text-o"></i>
							<span class="kt-nav__link-text text-uppercase">{{ name }}</span>
						</a>
					</li>

				</ul>
			</div>
		</div>
		<button
			class="btn btn-primary"
			:class="{disabled: !canBuySelectedRows.length }"
			@click="addtobasket"
		>
			<i class="flaticon2-shopping-cart-1"></i> {{ labelAddtobasket }}
		</button>
	</div>
</template>

<script>

const EXPORT_TYPES = ['csv', 'ods', 'xlsx'];

export default {

	data()
	{
		return { 
			selectedRows: [],
			page: window.location.pathname
		};
	},

	mounted() 
	{
		this.eventBus.$on('onSelectedRowsChanged', selectedRows => this.selectedRows = selectedRows);

		this.eventBus.$on('afterRequest', () => {
			this.page = window.location.pathname + window.location.search;
		});

		$(this.$refs.actions).on('click', event => {
			event.stopPropagation();
		});
	},

	computed: {

		options()
		{
			return this.$store.getters[`${this.$root.$namespace}/getToolbarOptions`];
		},

		eventBus()
		{
			return this.$root.$eventBus || this;
		},

		canBuySelectedRows()
		{
			return this.selectedRows.filter(row => (row.products[row.selected] || {}).canBuy);
		},

		localize() 
		{
			return Object.freeze({
				'addtobasket': BX.message('RS.B2BPORTAL.ADD_TO_BASKET_LABEL'),
				'actions':  BX.message('RS.B2BPORTAL.ACTIONS_LABEL'),
				'views': BX.message('RS.B2BPORTAL.VIEWS_LABEL'),
				'settings': BX.message('RS.B2BPORTAL.SETTINGS_LABEL'),
				'switcher':  BX.message('RS.B2BPORTAL.IMAGE_SWITCHER_LABEL'),
				'export':  BX.message('RS.B2BPORTAL.EXPORT_LABEL')
			})
		},

		labelAddtobasket()
		{
			return this.localize.addtobasket.replace('#COUNT#', this.canBuySelectedRows.length)
		},

		previewSwitcher()
		{
			return this.$store.getters[`${this.$root.$namespace}/isShowPreview`];
		},

		exports()
		{
			
			if (!this.options.export)
				return [];

			return this.options.exportTypes.filter(type => EXPORT_TYPES.includes(type)).map(type => {
				const uri = new BX.Uri((this.page || ''));
				uri.setQueryParam('export', type);

				return {
					name: type,
					url: uri.toString()
				};
			});
		},

		isShowActions()
		{
			return this.options.previewSwitcher || this.exports.length > 0;
		},

	},

	methods: {
		
		addtobasket() 
		{
			this.$emit('addtobasket', this.selectedRows);
		},

		togglePreviewSwitcher()
		{
			this.$store.dispatch(`${this.$root.$namespace}/togglePreview`);
		}

	},
}
</script>