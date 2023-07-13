<template>
	<div>
		<div class="modal fade" style="display: none" aria-hidden="true" ref="modal">

		</div>
	</div>
</template>

<script>
export default {
	props: {
		link: {
			type: String,
			default: ''
		},
		isVisible: {
			type: Boolean,
			default: false
		}
	},

	computed: {
		loc()
		{
			return this.$root.loc;
		}
	},

	watch()
	{
		isVisible()
		{
			console.log(123);
		}
	}
}
</script>