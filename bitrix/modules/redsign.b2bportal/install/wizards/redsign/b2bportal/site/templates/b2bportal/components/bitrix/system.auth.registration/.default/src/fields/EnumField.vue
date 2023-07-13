<template>
	<div>
		<div v-if="isRadio" class="kt-radio-list">
			<label class="kt-radio" v-for="v in prop.VALUES" :key="v.ID" >
				<input type="radio" :name="fieldName" :value="v.VALUE" v-model="valueM"> {{v.NAME}} 
				<span></span>
			</label>
		</div>
		<select v-else class="form-control" :name="fieldName" :id="fieldId" :multiple="multiple" :required="required" v-model="valueM">
			<option v-for="v in prop.VALUES" :key="v.ID" :value="v.VALUE">{{v.NAME}}</option>
		</select>
	</div>
</template>

<script>
import FieldMixin from './FieldMixin';

export default {
	mixins: [FieldMixin],

	props: {
		value: String | Array,
		multiple: {
			type: Boolean,
			default: false
		}
	},

	data()
	{
		return {
			valueM: this.value
		}
	},
	
	computed: {
		isRadio()
		{
			return !this.multiple && this.prop.SETTINGS.MULTIELEMENT == 'Y';
		}
	}
}
</script>