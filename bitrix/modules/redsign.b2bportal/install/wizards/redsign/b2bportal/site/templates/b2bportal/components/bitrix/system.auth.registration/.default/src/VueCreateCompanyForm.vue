<template>
	<div>
		<div class="row">
			<div class="col-12 form-group">
				<select class="form-control" name="COMPANY_PERSON_TYPE" id="COMPANY_PERSON_TYPE" v-model="personType">
					<option v-for="personType in personTypes" :key="personType.ID" :value="personType.ID">{{ personType.NAME }}</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-12 form-group">
				<label for="COMPANY_NAME">{{ messages.FIELD_PROFILE_NAME }} <span class="text-danger">*</span></label>
				<input class="form-control" type="text" name="COMPANY_NAME" id="COMPANY_NAME" v-model="companyName" required>
			</div>
		</div>

		<div v-for="group in groups" :key="group.ID">
			<div class="kt-heading kt-heading--md">{{ group.NAME }}</div>
			<div class="row">
				<div class="col-12 col-md-6 form-group" v-for="prop in filterPropsByGroup(group.ID)" :key="prop.ID">
					<FormField :prop="prop" />
				</div>
			</div>
		</div>
	</div>
</template>

<script>


import FormField from './Field.vue';  


const props = {
	personTypes: Array,
	orderProps: Array,
	orderPropsGroups: Array
};

const components = {
	FormField
};
 
export default {
	components,
	props,

	data()
	{
		let personType = 0;
		let companyName = this.$root.values.COMPANY_NAME;
		
		if (this.personTypes.length)
		{
			if (this.personTypes.find(p => p.ID == this.$root.values.COMPANY_PERSON_TYPE))
			{
				personType = this.$root.values.COMPANY_PERSON_TYPE;
			}
			else
			{
				personType = this.personTypes[0].ID;
			}
		}
		
		return {
			personType,
			companyName
		};
	},

	computed: {

		messages()
		{
			return (Object.freeze({
				'FIELD_PROFILE_NAME': BX.message('RS_B2B_REGISTRATION_FIELD_PROFILE_NAME')
			}));
		},

		groups()
		{
			return this.orderPropsGroups.filter(group => group.PERSON_TYPE_ID == this.personType && this.filterPropsByGroup(group.ID).length);
		},
		skipProps()
		{
			return this.orderProps.filter(prop => prop.IS_LOCATION == 'Y')
				.map(prop => prop.INPUT_FIELD_LOCATION);
		},
		props()
		{
			return this.orderProps.filter(prop => prop.PERSON_TYPE_ID == this.personType && !this.skipProps.includes(prop.ID));
		},
		locationProps()
		{
			return this.props.filter(prop => prop.TYPE == 'LOCATION')
		}
	},

	methods: {
		filterPropsByGroup(groupId) 
		{
			return this.props.filter(prop => prop.PROPS_GROUP_ID == groupId);
		}
	},

}
</script>