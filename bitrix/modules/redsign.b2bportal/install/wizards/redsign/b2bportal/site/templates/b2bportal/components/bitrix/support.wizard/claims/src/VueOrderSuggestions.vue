<template>
	<div class="d-block position-relative">
		<div :class="loadingClasses">
			<input 
				ref="input"
				type="text"
				class="form-control"
				:placeholder=this.placeholder
				:name="name"
				v-model="query"
				autocomplete="off"
				@focus="handleFocus"
				@blur="handleBlur"
				@input="handleInput"
			>
		</div>
		<div 
			ref="dropdown"
			class="dropdown-menu dropdown-menu-anim dropdown-menu-fit dropdown-menu-right dropdown-menu-xl ps ps--active-y mw-100"
			:class="{ show: isVisibleSuggestions && !isLoading }"
			:style="dropdownStyles" 
			data-scroll="true" 
		>
			<a class="dropdown-item flex-column" href="#" v-for="(item, index) in suggestions" :key="index" @click.prevent="select(item)">
				{{ item }}
			</a>
		</div>
	</div>
</template>
<script>

const GET_ORDERS_ACTION_NAME = 'redsign:b2bportal.api.orders.getOrders';

export default {

	props:
	{
		name: {
			type: String,
			default: ''
		},
		value: {
			type: String,
			default: ''
		},
		minLength: {
			type: [Number, String],
			default:  0
		},
		placeholder: {
			type: String,
			default: ''
		},
	},

	data()
	{
		return {
			cursor: 0,
			isFocused: false,
			loadings: [],

			query: this.value,
			suggestions: []
		}
	},

	computed: {  

		isVisibleSuggestions()
		{
			return (
				this.isFocused && 
				this.suggestions.length > 0
			);
		},

		dropdownStyles()
		{
			return {
				maxHeight: '240px',
				overflow: 'hidden'
			}
		},

		isLoading()
		{
			return Boolean(this.loadings.length);
		},

		loadingClasses()
		{
			if (this.isLoading)
			{
				return ['kt-spinner', 'kt-spinner--input', 'kt-spinner--sm', 'kt-spinner--brand', 'kt-spinner--right'];
			}

			return [];
		},
	},

	mounted()
	{
		const clickOutside = (event) => {

			if (this.isFocused && this.$refs.input !== document.activeElement)
			{
				const target = event.target;
				if (target != this.$el && !this.$el.contains(target))
				{
					this.$refs.input.blur();
					this.isFocused = false;
				}
			}
		}

		document.addEventListener('mouseup', clickOutside);
		document.addEventListener('touchstart', clickOutside);

		document.addEventListener('keydown', (event) => {
			const keyName = event.key;

			if (this.isFocused && keyName == 'Escape')
			{
				this.isFocused = false;
				this.$refs.input.blur();
			}
		});
	},

	methods: {
		
		handleFocus()
		{
			this.isFocused = true;
			this.load();
		},

		handleBlur()
		{
			const relatedTarget = event.relatedTarget || document.activeElement;

			if (relatedTarget)
			{
				if (
					relatedTarget != this.$refs.dropdown && 
					!this.$refs.dropdown.contains(relatedTarget)
				)
				{
					this.isFocused = false;
				}
			}
			else
			{   
				this.isFocused = false;
			}
		},

		handleInput()
		{
			this.$emit('input', this.query);
			
			if (this.query.length >= this.minLength)
			{
				this.load(this.query);
			}
		},

		select(suggestion)
		{
			this.query = suggestion;
			
			this.isFocused = false;
			this.$refs.input.blur();	
		},

		async load(query)
		{
			this.loadings.push(true);
			
			const result = await this.loadSuggestions(query);
			this.suggestions = result.data;
			
			this.loadings.pop();
		},

		loadSuggestions(query)
		{
			const data = {
				accountNumber: this.query
			};

			return new Promise((resolve, reject) => {
				BX.ajax.runAction(GET_ORDERS_ACTION_NAME, { data })
					.then(resolve, reject);
			});
		}
	},

	watch: 
	{
		value()
		{
			this.query = value;
		}
	}
}
</script>