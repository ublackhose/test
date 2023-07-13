<template>
	<div>
		<textarea class="form-control" :name="fieldName" :id="fieldId" v-model="inputValue" :required="required"></textarea>
	</div>
</template>

<script>
import FieldMixin from './FieldMixin';
import InputValueMixin from './InputValueMixin';
import { getSuggestValue } from '../utils';

export default {
	mixins: [FieldMixin, InputValueMixin],

	mounted()
	{
		
		if (this.prop.FIELD_TYPE)
		{
			this.$root.$on('selectSuggest', suggestion => {
				this.inputValue = getSuggestValue(suggestion, this.prop.FIELD_TYPE);
			});
		}
	},
}
</script>