<template>
	<div class="dropdown" v-if="Object.keys(variants).length">
		<button
			class="btn"
			:class="getButtonClass"
			data-toggle="dropdown"
		>
			<i :class="getButtonIconClass" v-if="!hideButtonIcon"></i>
			{{ label }}
		</button>
		<div
			class="dropdown-menu"
			:class="getDropdownMenuClass"
		>
			<ul class="kt-nav">
				<li
					class="kt-nav__item"
					v-for="(variant, index) in variants"
					:key="index"
				>
					<a
						class="kt-nav__link"
						href="#"
						@click="onClick(index)"
					>
						<i
							class="kt-nav__link-icon"
							:class="variant.icon"
							v-if="variant.icon"
						/>
						<span class="kt-nav__link-text">{{ variant.text }}</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
export default {

	props: {
		variants: {
			type: [Array, Object],
			default: () => [],
		},
		label: {
			type: String,
			required: true,
		},
		buttonClass: {
			type: String,
			default: '',
		},
		buttonIconClass: {
			type: String,
			default: '',
		},
		hideButtonIcon: {
			type: Boolean,
			default: false
		},
		dropdownMenuClass: {
			type: String,
			default: '',
		},
	},

	computed: {

		getButtonClass()
		{
			return ' ' + (this.buttonClass ? this.buttonClass : 'btn-default')
		},

		getButtonIconClass()
		{
			return ' ' + (this.buttonIconClass ? this.buttonIconClass : 'flaticon2-soft-icons')
		},

		getDropdownMenuClass()
		{
			return ' ' + (this.dropdownMenuClass ? this.dropdownMenuClass : '')
		},

	},

	methods: {
		
		onClick(index)
		{
			this.$emit('on-click', this.variants[index]);
		},

	}
}
</script>
