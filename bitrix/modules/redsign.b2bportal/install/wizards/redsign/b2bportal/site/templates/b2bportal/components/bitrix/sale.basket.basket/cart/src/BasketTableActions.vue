<template>
	<ul class="kt-nav">
		<li class="kt-nav__item">
			<a data-target="#modalImportFile" data-toggle="modal" class="kt-nav__link" href="#" @click.prevent="$emit('remove')" >
				<i class="kt-nav__link-icon flaticon2-trash"></i>
				<span class="kt-nav__link-text">{{ messages.SBB_DELETE }}</span>
			</a>
		</li>
		<li class="kt-nav__item" v-for="basket in baskets" :key="basket.ID">
			<a data-target="#modalImportFile" data-toggle="modal" class="kt-nav__link" href="#" @click.prevent="$emit('move', basket)">
				<i class="kt-nav__link-icon flaticon2-shopping-cart-1"></i>
				<span class="kt-nav__link-text">{{ messages.SBB_MOVE }} <span class="text-decoration-underline">{{ basket.NAME }}</span></span>
			</a>
		</li>
	</ul>
</template>
<script>
export default {

	store: B2BPortal.store,

	computed: {
		
		baskets()
		{
			return this.$store.getters.notSelectedBaskets;
		},

		messages()
		{
			return (
				Object.freeze(
					Object.keys(BX.message).filter(message => message.startsWith('SBB'))
						.reduce((obj, message) => { obj[message.slice(message)] = BX.message(message); return obj; }, {})
				)
			);
		},

	}
}
</script>