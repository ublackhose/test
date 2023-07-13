<template>
	<div class="input-group flex-nowrap">
		<div class="input-group-prepend">
			<button 
				class="btn btn-outline-secondary btn-sm" 
				type="button"
				:disabled="isDisabled || inputValue <= min"
				@click="handleMinus"
			>-</button>
		</div>
		<input
			ref="input"
			type="number"
			class="product-amount-field form-control form-control-sm"
			:class="{'is-invalid': isInvalid, 'disabled' : isDisabled}"
			:min="Number(min)"
			:max="Number(max)"
			:step="Number(step)"
			:disabled="isDisabled"
			v-model.number="inputValue"
			@input="handleInput"
			@change="handleChange"
			tabindex="2"
		>
		<div class="input-group-append">
			<button 
				class="btn btn-outline-secondary btn-sm" 
				type="button" 
				:disabled="isDisabled || inputValue >= max"
				@click="handlePlus"
			>+</button>
		</div>
	</div>
</template>
<script>

const changed = BX.debounce((context) => context.$emit('change'), 250);

export default {

	props: {
		min: {
			type: Number | String,
			default: 1
		},
		max: {
			type: Number | String,
			default: 999
		},
		step: {
			type: Number | String,
			default: 1
		},
		value: {
			type: Number | String,
			default: 'sss'
		},
		isInvalid: {
			type: Boolean,
			default: false
		},
		isDisabled: {
			type: Boolean,
			default: false
		}
	},

	data()
	{
		return {
			inputValue: this.value
		};
	},

	methods: {
		handleInput()
		{
			this.$emit('input', this.inputValue);
		},

		handleButton()
		{
			this.handleInput();
			this.handleChange();
		},

		handleChange()
		{
			changed(this);
		},

		handlePlus()
		{
			this.inputValue = Math.round((this.inputValue + this.step + Number.EPSILON) * 100) / 100;
			this.handleButton();
		},

		handleMinus()
		{
			this.inputValue = Math.round((this.inputValue - this.step + Number.EPSILON) * 100) / 100;
			this.handleButton();
		}
	},

	watch: {
		value(newVal)
		{
			this.inputValue = newVal;
		}
	}
}
</script>
