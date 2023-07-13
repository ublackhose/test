<template>
	<div
		:summary="summary"
		class="row align-items-center"
	>
		<div class="col-12 text-right">
			<div class="form-group">
				<div v-if="summary.count > 0">
					{{ localize.SBB_ITEMS_COUNT }}: {{ summary.count }}
				</div>
				<div v-if="summary.allWeight > 0">
					{{ localize.SBB_WEIGHT }}: {{ summary.allWeight_FORMATED }}
				</div>
				<div v-if="summary.allVATSum > 0">
					{{ localize.SBB_VAT }}: <span v-html="summary.allVATSum_FORMATED"></span>
				</div>
				<div v-if="summary.allSum > 0">
					<strong>{{ localize.SBB_TOTAL }}</strong>: <span v-html="summary.allSum_FORMATED"></span>
				</div>
			</div>
			<div class="dropdown dropdown-inline" v-if="exportTypes.length">
				<a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="true">
					{{ localize.SBB_EXPORT }}
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<ul class="kt-nav">
						<li class="kt-nav__item" v-for="(type, index) in exportTypes" :key="index">
							<a :href="exportPath(type)" target="_blank" class="kt-nav__link">
								<i class="kt-nav__link-icon la la-file-text-o"></i>
								<span class="kt-nav__link-text text-uppercase">{{ type }}</span>
							</a>
						</li>
						
					</ul>
				</div>
			</div>
			<template v-if="pathToOrder">
				<a :href="pathToOrder" class="btn btn-primary">{{ localize.SBB_ORDER }}</a>
			</template> 
		</div>
	</div>
</template>

<script>
export default {

	props: {
		pathToOrder: {
			type: String,
			default: '',
		},
		summary: {
			type: Object,
			default: () => {},
		},
		exportTypes: {
			type: Array,
			default: () => []
		}
	},

	computed: {

		localize()
		{
			return Object.freeze({
				"SBB_ITEMS_COUNT": BX.message('SBB_ITEMS_COUNT'),
				"SBB_WEIGHT": BX.message('SBB_WEIGHT'),
				"SBB_VAT": BX.message('SBB_VAT'),
				"SBB_EXPORT": BX.message('SBB_EXPORT'),
				"SBB_TOTAL": BX.message('SBB_TOTAL'),
				"SBB_ORDER": BX.message('SBB_ORDER'),
			})
		}

	},

	methods: {
		exportPath(type)
		{
			const uri = new BX.Uri((window.location.pathname || ''));
			uri.setQueryParam('export', type);

			return uri.toString();
		}
	},

}
</script>
