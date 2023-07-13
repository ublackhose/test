<template>
	<div>
		<div v-html="html"></div>
	</div>
</template>

<script>
import FieldMixin from './FieldMixin';

const processLocation = (html) => {
	const processedHTML = BX.processHTML(html);
	const processedScripts = processedHTML.SCRIPT;

	if (processedScripts && processedScripts.length)
	{
		processedScripts.forEach(SCRIPT => {
			BX.evalGlobal(SCRIPT.JS);
		})
	}
};

const initDeferredLocations = () => {
	if(typeof window.BX.locationsDeferred != 'undefined')
	{
		for(let k in window.BX.locationsDeferred)
		{
			window.BX.locationsDeferred[k].call(this);
			window.BX.locationsDeferred[k] = null;
			delete(window.BX.locationsDeferred[k]);
		}
	}
};

export default {
	mixins: [FieldMixin],

	computed: {

		html()
		{
			return this.value
		}

	},

	mounted()
	{
		this.$nextTick(() => {
			processLocation(this.html);
			initDeferredLocations();
		});
	},
}
</script>