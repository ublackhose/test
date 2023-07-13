<template>
	<div>
		<SuggestInput v-model="inputValue" :name="fieldName" :id="fieldId" :loadSuggestions="getSuggestions" @select="select" v-slot="slotProps">
			<div :class="{'text-line-through': isLiquid(slotProps.suggestion)}" v-html="getSuggestData(slotProps.suggestion)"></div>
			<div>
				<span v-html="getSuggestData(slotProps.suggestion, 'INN')"></span> 
				<span v-html="getSuggestData(slotProps.suggestion, 'ADDRESS')"></span>
			</div>
		</SuggestInput>
	</div>
</template>

<script>
import FieldMixin from './FieldMixin';
import InputValueMixin from './InputValueMixin';
import { getSuggestValue }  from '../utils';

export default {
	mixins: [FieldMixin, InputValueMixin],

	components: { SuggestInput: B2BPortal.Vue.Components.SuggestInput },

	computed: {
		suggestType()
		{
			return this.prop.FIELD_TYPE;
		}
	},

	mounted() 
	{
		this.$root.$on('selectSuggest', suggestion => {
			this.inputValue = getSuggestValue(suggestion, this.suggestType);
		});
	},

	methods: {

		getSuggestData(suggestion, fieldType = '')
		{
			return this.inputValue
				.trim()
				.split(/[\s,]+/)
				.reduce((value, query) => {
					return value.replace(
						new RegExp('(' + query + ')', 'gi'),
						'<b class="text-primary">$1</b>'
					)
				}, getSuggestValue(suggestion, fieldType));
		},

		isLiquid(suggestion)
		{
			const status = ((suggestion.data || {}).state || {}).status;
			return status !== 'ACTIVE' && status !== 'REORGANIZING ';
		},

		async getSuggestions()
		{
			const result = await BX.ajax.runAction('redsign:b2bportal.api.dadata.suggest', {
				data: {
					actionName: 'party',
					data: {
						query: this.inputValue,
						count: 7
					}
				}
			});

			const isSuccess = result.status === 'success';
			
			return isSuccess && result.data.suggestions ? result.data.suggestions : []
		},

		select(suggestion)
		{
			this.$root.$emit('selectSuggest', suggestion);
		}

	}
}
</script>