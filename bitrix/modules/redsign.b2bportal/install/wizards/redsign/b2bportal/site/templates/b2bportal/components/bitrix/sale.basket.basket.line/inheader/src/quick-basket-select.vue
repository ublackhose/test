<template>
	<div class="dropdown">
		<button 
			type="button" 
			class="btn btn-clean" 
			:class="{ 'dropdown-toggle': canToggle }"
			:style="{ color: selected.COLOR }" 
			data-toggle="dropdown"
			data-offset="0,2px"
		>
			{{ selected.NAME }}
		</button>
		<div class="dropdown-menu" x-placement="bottom-end" v-if="canToggle">
			<a
				v-for="item in items"
				:key="item.ID"
				class="dropdown-item"
				href="#"
				@click.prevent="select(item)"
			>
				{{ item.NAME }} 
				<span 
					class="kt-badge kt-badge--primary ml-2" 
					v-if="item.CNT" 
					:style="{
						background: item.COLOR
					}"
				>
					{{ item.CNT }}
				</span>
			</a>
		</div>
	</div>
</template>

<script>
export default {
	computed: {
		...Vuex.mapGetters({
			selected: 'multicart/selected',
			items: 'multicart/notSelected'
		}),
		canToggle() { return !!this.items.length; }
	},
	methods: {
		select({ CODE })
		{
			this.$store.dispatch('multicart/select', CODE)
				.then(() => {
					return this.$store.dispatch('cart/fetch');
				});
		}
	}
}
</script>