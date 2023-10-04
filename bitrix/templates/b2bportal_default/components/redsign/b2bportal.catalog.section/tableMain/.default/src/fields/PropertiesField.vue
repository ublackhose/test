<template>
	<div>
		<div v-for="prop in row.props">
			<span class="mr-2"><b>{{ prop.name }}</b>: <span v-html="prop.value"></span></span>
		</div>
	</div>
</template>
<script>
import FieldMixin from './FieldMixin';

export default {
	mixins: [FieldMixin],
}
</script>