<template>
	<div>
		<div v-if="isMultiple">
			<label :for="fieldId + '_0'">{{ prop.NAME }} <span class="text-danger" v-if="isRequired">*</span></label>
			<div v-if="prop.TYPE=='ENUM'">
				<EnumField :fieldName="fieldName + '[]'" :fieldId="fieldId" :prop="prop" :value="value" :required="isRequired" :multiple="true" />
			</div>
			<div v-else>
				<div v-for="(v, i) in value" class="mb-3">
					<component :is="component" :fieldName="fieldName + '[]'" :fieldId="fieldId + '_' + i" :value="value[i]" :prop="prop"></component>
				</div>
				<a href="#" class="btn btn-primary" @click.prevent="addValue">{{ messages.ADD_FIELD }}</a>
			</div>
		</div>
		<div v-else>
			<label :for="fieldId">{{ prop.NAME }} <span class="text-danger" v-if="isRequired">*</span></label>
			<FileField :fieldName="fieldName + '[]'" :fieldId="fieldId" :prop="prop" :value="value" :required="isRequired" v-if="prop.TYPE=='FILE'" />
			<component :is="component" :fieldName="fieldName" :fieldId="fieldId" :prop="prop" :value="value" :required="isRequired" v-else></component>
		</div>
	</div>
</template>
<script>

import StringField from './fields/StringField.vue'; 
import NumberField from './fields/NumberField.vue';
import CheckboxField from './fields/CheckboxField.vue';
import LocationField from './fields/LocationField.vue';
import FileField from './fields/FileField.vue'; 
import EnumField from './fields/EnumField.vue'; 
import SuggestField from './fields/SuggestField.vue';
import TextareaField from './fields/TextareaField.vue';
import DateField from './fields/DateField.vue';

const components = {
	StringField,
	NumberField,
	CheckboxField,
	LocationField, 
	FileField,
	EnumField,
	SuggestField,
	TextareaField,
	DateField
};

export default {  

	components,

	props: {
		prop: Object,
		index: {
			type: Number,
			default: 0
		}
	},

	data()
	{
		let value = this.$root.values['COMPANY_PROP_' + this.prop.ID];
		if (this.prop.MULTIPLE == 'Y')
		{
			if (!BX.type.isArray(value) || !value.length)
			{
				value = [''];
			}
		}

		return {
			value
		};
	},

	computed: {

		messages()
		{
			return (Object.freeze({
				'ADD_FIELD': BX.message('RS_B2B_REGISTRATION_ADD_FIELD')
			}));
		},

		component()
		{
			if (this.prop.FIELD_TYPE && (this.prop.FIELD_TYPE == 'INN' || this.prop.FIELD_TYPE === 'ORGANIZATION_NAME'))
			{
				return SuggestField;
			}

			switch(this.prop.TYPE)
			{
				case 'ENUM':
				case 'SELECT':
					return EnumField;

				case 'FILE':
					return FileField;
					
				case 'LOCATION':
					return LocationField;

				case 'Y/N':
					return CheckboxField;

				case 'NUMBER':
					return NumberField;

				case 'DATE':
					return DateField;

				case 'STRING':
				default:
					if (this.prop.SETTINGS.MULTILINE === 'Y') return TextareaField;
					return StringField
			}
		},

        fieldName()
        {
            return 'COMPANY_PROP_' + this.prop.ID ;
		},
		
		fieldId()
		{
			return 'COMPANY_PROP_' + this.prop.ID;
		},

		isMultiple()
		{
			return this.prop.MULTIPLE == 'Y';
		},

		isRequired()
		{
			return this.prop.REQUIRED === 'Y';
		}
	},

	methods: {
		
		addValue()
		{
			if (BX.type.isArray(this.value))
			{
				if (this.prop.TYPE == 'LOCATION')
				{
					this.value.push(
						this.prop.OUTPUT_HTML
							.replace(/indexkey/g, this.value.length)
							.replace(/(sls-\d+)/g, '$1_' + this.value.length)
					);
				}
				else
				{
					this.value.push('');
				}
			}
		}
	},

}  
</script>