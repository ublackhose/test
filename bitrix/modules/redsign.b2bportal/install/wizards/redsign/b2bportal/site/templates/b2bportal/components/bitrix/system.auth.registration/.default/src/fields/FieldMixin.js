export default {
	props: {
		prop: Object,
		fieldName: String,
		fieldId: String,
		value: String,
		required: {
			type: Boolean,
			default: false
		}
	},
	
	methods: {
		decodeVal(html)
		{
			const decoder = document.createElement('div');
			decoder.innerHTML = html;
			
			return decoder.textContent;
		}
	}
} 