<template>
	<div>
		 <input type="number" class="form-control" :name="fieldName"  :id="fieldId" :value="value" :required="required">
	</div>
</template>

<script>
import FieldMixin from './FieldMixin';
export default {
	mixins: [FieldMixin],
}
</script>