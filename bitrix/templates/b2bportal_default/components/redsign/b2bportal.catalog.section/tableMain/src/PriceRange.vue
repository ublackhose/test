<template>
	<div class="price-range">
		<a href="#" class="price-range__link" ref="link" @click.prevent>  ? </a>
		<div class="d-none">
			<div class="price-range-popup" ref="popup">
				<div class="d-block" v-for="(range, name, index) in ranges">
					<template v-if="prices[range.hash] && prices[range.hash][type]">
						<span v-if="range.sort_from > 0">
							<b>{{ range.quantity_from }}<template v-if="range.sort_to == 'INF'">+</template></b>
						</span>
						<span v-if="range.sort_to !== 'INF'">
							<template v-if="range.sort_from > 0">-</template>
							<b>{{ range.quantity_to }}</b>
						</span>
						<span> {{ measureTitle }}</span><span>: <b v-html="prices[range.hash][type]"></b></span>
					</template>
				</div>		
			</div>
		</div>
	</div>
</template>

<script>
export default {
	
	props: {
		ranges: Object,
		prices: Object,
		type: String,
		measureTitle: String
	},

	computed: {

		messages()
		{
			return (Object.freeze({
				CT_BCE_CATALOG_RANGE_FROM: BX.message('CT_BCE_CATALOG_RANGE_FROM'),
				CT_BCE_CATALOG_RANGE_TO: BX.message('CT_BCE_CATALOG_RANGE_TO')
			}));
		},
	},

	mounted()
	{
		$(this.$refs.link).popover({
			html: true,
			placement: 'bottom',
			content: this.$refs.popup,
			trigger: 'hover',
			boundary: 'window'
		});
	}
}
</script>

<style lang="scss" scoped>

.price-range {
	display: inline-block;
	vertical-align: middle;
	
	&__link {
		font-size: 10px;
		line-height: 0;
		display: inline-block;
		vertical-align: text-bottom;
		padding: 8px 5.5px;
		border: 1px solid currentColor;
		border-radius: 50%;
		transition: .3s;

		&:hover,
		&:focus,
		&:active {
			background-color: #5867dd;
			border-color: #5867dd;
			color: #fff;
		}
	}
}

</style>
