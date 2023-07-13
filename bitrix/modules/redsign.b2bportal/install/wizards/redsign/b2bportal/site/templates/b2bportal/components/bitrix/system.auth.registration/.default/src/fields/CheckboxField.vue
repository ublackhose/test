<template>
	<div>
		<label class="kt-checkbox">
			<input type="checkbox" :name="fieldName" :id="fieldId" :required="required" value="Y" :checked="value == 'Y'">
			<span></span>
		</label>
	</div>
</template>

<script>
import FieldMixin from './FieldMixin';

export default {
	mixins: [FieldMixin]
}
</script>