<template>
    <div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" :name="fieldName" :id="fieldId" :required="required" @change="inputValue = event.targe.value">
            <label class="custom-file-label" :for="fieldId" :data-browse="messages.FILE_BROWSE" ref="label">{{ inputValue || messages.FILE_CHOOSE }}</label>
        </div> 
    </div>
</template>

<script>
import FieldMixin from './FieldMixin';

export default {
	mixins: [FieldMixin],

	data()
	{
		return {
			inputValue: false
		}
	},
	
	computed: {
		messages()
		{
			return (Object.freeze({
				'FILE_CHOOSE': BX.message('RS_B2B_REGISTRATION_FILE_CHOOSE'),
				'FILE_BROWSE': BX.message('RS_B2B_REGISTRATION_FILE_BROWSE')
			}));
		}
	},
}
</script>