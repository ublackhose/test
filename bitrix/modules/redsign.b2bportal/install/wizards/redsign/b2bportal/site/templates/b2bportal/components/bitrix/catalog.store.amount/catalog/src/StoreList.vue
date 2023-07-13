<template>
	<div
		:rows="rows"
		:arParams="arParams"
		class="kt-list"
	>
		<div
			v-for="(store, key) in stores"
			v-bind:key="store.ID"
		>
			<div class="kt-list__item">
				<span class="kt-list__text">
					<div v-if="store.NAME">{{ store.NAME }}</div>
					<div v-if="store.ADDRESS" class="text-muted">{{ store.ADDRESS }}</div>
				</span>
				<span class="kt-list__time">
					<VueQuantity
						v-bind:quantity="Number(store.REAL_AMOUNT)"
						:measure="arParams.MEASURE_TITLE"
					/>
				</span>
			</div>
			<div
				v-if="key + 1 != stores.length"
				class="kt-separator kt-separator--space-xs kt-separator--border-dashed"></div>
		</div>

	</div>
</template>

<script>
export default {

	components: {
		VueQuantity: B2BPortal.Vue.Components.Quantity
	},

	props: {
		rows: {
			type: Array,
			default: () => [],
		},
		arParams: {
			type: Object,
			default: () => {},
		},
	},

	computed: {

		stores()
		{
			return this.rows.filter(store => store.SHOW)
		},

	},

}
</script>
