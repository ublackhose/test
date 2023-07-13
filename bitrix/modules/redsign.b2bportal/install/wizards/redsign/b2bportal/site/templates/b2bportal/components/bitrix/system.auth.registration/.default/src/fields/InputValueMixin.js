export default {
	props: {
		value: String,
	},

	data()
	{
		return {
			inputValue: this.decodeVal(this.value)
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