<template>
	<div>
		<input type="text" class="form-control" :name="fieldName"  :id="fieldId" ref="input" :required="required">
	</div>
</template>

<script>
import FieldMixin from './FieldMixin';

export default {
	mixins: [FieldMixin],

	computed: {
		showTime()
		{
			return this.prop.SETTINGS.TIME === 'Y';
		}
	},

	mounted()
	{
		this.$nextTick(() => {
			if (this.showTime)
			{
				$(this.$refs.input).datetimepicker({
					format: 'dd.mm.yyyy hh:ii:ss', 
					autoclose: true,
				});
			}
			else
			{
				$(this.$refs.input).datepicker({
					format: 'dd.mm.yyyy',
					autoclose: true,
				});
			}
		});
	}
}
</script>