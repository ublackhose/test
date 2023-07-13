<template>
	<img :src="src" :alt="title" class="img-fluid" ref="image">
</template>
<script>
export default {
	props: {
		src: String,
		title: String
	},

	mounted()
	{
		this.$nextTick(() => {
			$(this.$refs.image).popover({
				trigger: 'hover',
				placement: 'right',
				boundary: 'window',
				html: true,
				title: '',
				content: function content() {
					return "<img class=\"img-fluid\" src=\"".concat(this.src, "\" />");
				},
			});
		});
	}
}
</script>