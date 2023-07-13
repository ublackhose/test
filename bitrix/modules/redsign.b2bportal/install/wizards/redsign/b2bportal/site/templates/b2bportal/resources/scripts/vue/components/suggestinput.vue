<template>
	<div class="d-block" :style="styles">
		<div :class="loadingClasses">
			<input 
				ref="input"
				type="text"
				class="form-control"
				:placeholder="placeholder"
				:name="name"
				v-model="query"
				autocomplete="off"
				@focus="handleFocus"
				@blur="handleBlur"
				@input="handleInput"
				@keydown.down="handleDown"
				@keydown.up="handleUp"
				@keydown.enter.prevent="handleEnter"
			>
		</div>
		<div 
			ref="dropdown"
			class="dropdown-menu dropdown-menu-anim dropdown-menu-fit dropdow-menu-suggest ps ps--active-y w-100 mw-100"
			:class="{ show: isVisibleSuggestions && !isLoading }"
			data-scroll="true"
			:style="dropdownStyles"
			tabindex="-1"
		>
			<div class="kt-scroll">
				<div 
					ref="suggestions"
					class="dropdown-item flex-column" 
					:class="{cursor: index === cursor }"
					v-for="(item, index) in suggestions" :key="index" 
					@click.prevent="select(item)"
					@mouseover="onSuggestionHover(index)"
				>
					<slot v-bind:suggestion="item">{{ item.value }}</slot>
				</div>
			</div>
		</div>
	</div>
</template>
<script>

const cache = {};

export default {
	props: {
		styles: {
			type: Object,
			default: () => ({ position: 'relative' })
		},
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
			default:  3
		},
		placeholder: {
			type: String,
			default: ''
		},
		dropdownStyles: {
			type: [Object, String],
			default: ''
		},
		loadSuggestions: {
			type: Function,
			default: () => ({})
		}
	},

	data()
	{
		return {
			cursor: -1,
			isFocused: false,
			query: this.value,
			suggestions: [],
			loadings: [],
		};
	},

	computed: {
		isVisibleSuggestions()
		{
			return (
				this.query.length >= this.minLength &&
				this.isFocused && 
				this.suggestions.length > 0
			);
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

		handleBlur(event)
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

		handleDown()
		{
			if (this.cursor < this.suggestions.length - 1)
			{
				this.cursor++;
			}
			else
			{
				this.cursor = 0;
			}

			this.checkScroll();
		},

		handleUp()
		{
			if (this.cursor > 0)
			{
				this.cursor--;
			}
			else
			{
				this.cursor = this.suggestions.length - 1;
			}

			this.checkScroll();
		},

		checkScroll()
		{
			const item = this.$refs.suggestions[this.cursor];
			const dropdown = this.$refs.dropdown;

			if (this.cursor === 0)
			{
				dropdown.scrollTo(0, 0);
			}
			else if (this.cursor >= this.suggestions.length)
			{
				dropdown.scrollTo(0, dropdown.scrollHeight - dropdown.clientHeight);
			}
			else if (item.clientHeight + item.offsetTop > dropdown.scrollTop + dropdown.clientHeight)
			{
				dropdown.scrollTo(0, Math.abs(dropdown.clientHeight - item.offsetTop - item.clientHeight));
			}
			else if (item.offsetTop < dropdown.scrollTop)
			{
				dropdown.scrollTo(0, item.offsetTop);
			}
		},

		onSuggestionHover(index)
		{
			if (this.$refs.suggestions[index])
			{
				this.$refs.suggestions[index].addEventListener('mousemove', () => this.cursor = index, { once: true });
			}
			
			// this.cursor = index;
		},

		handleEnter()
		{
			this.select(this.suggestions[this.cursor]);
		},

		handleInput()
		{
			this.$emit('input', this.query);

			this.load();
		},

		async load() 
		{
			if (this.query.length >= this.minLength)
			{
				this.loadings.push(true);
	
				if (cache[this.query])
				{
					this.suggestions = cache[this.query];
				}
				else
				{
					this.suggestions = await this.loadSuggestions();
					cache[this.query] = this.suggestions;
				}
	
				this.loadings.pop(true);
				this.reset();
			}
		},

		select(item)
		{
			this.$emit('select', item);

			this.isFocused = false;
			this.$refs.input.blur();
		},

		reset()
		{
			this.cursor = -1;
		}
	},

	watch: {
		value(newVal)
		{
			this.query = newVal;
		}
	}
}
</script>