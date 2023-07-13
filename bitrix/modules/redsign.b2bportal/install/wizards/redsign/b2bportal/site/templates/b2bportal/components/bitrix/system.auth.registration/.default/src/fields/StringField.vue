<template>
	<div>
		<div v-if="isPhoneNumber">
			<div class="kt-input-icon kt-input-icon--left">
				<input type="text" class="form-control" :name="fieldName" :id="fieldId" v-model="inputValue" :required="required" ref="input">
				<span class="kt-input-icon__icon kt-input-icon__icon--left">
					<span><span ref="flag"></span></span>
				</span>
			</div>
		</div>
		<input :type="inputType" class="form-control" :name="fieldName" :id="fieldId" v-model="inputValue" :required="required" ref="input" v-else>
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

		if (this.isPhoneNumber)
		{
			new BX.PhoneNumber.Input({
				node: this.$refs.input,
				forceLeadingPlus: false,
				flagNode: this.$refs.flag, 
            	flagSize: 16,
				defaultCountry: 'ru'
			});
		}
	},

	computed: {
		inputType()
		{
			return this.prop.IS_EMAIL === 'Y' ? 'email' : 'text';
		},

		isPhoneNumber()
		{
			return this.prop.IS_PHONE === 'Y';
		}
	},
}
</script>