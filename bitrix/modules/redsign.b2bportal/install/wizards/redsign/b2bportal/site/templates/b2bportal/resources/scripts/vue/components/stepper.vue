<template>
	<div>
		<transition name="fade">
			<div v-if="show">
				<slot :name="this.activeStep" v-bind="scopeProps"></slot>
			</div>
		</transition>
	</div>
</template>
<script>

const steps = [
	{
			
	},

	{

	}
];

export default {

	props: {
		steps: Array,
		currentStep: {
			type: Number,
			default: 0
		}
	},

	computed:
	{
		stepsCount()
		{
			return this.steps.length;
		},

		isLastStep()
		{
			return this.stepIndex >= this.stepsCount;
		},

		isFirstSteep()
		{
			return this.stepIndex === 0;
		},

		activeStep()
		{
			return this.steps[this.stepIndex];
		},

		scopeProps()
		{
			return {
				index: this.stepIndex,
				name: this.activeStep,
				isFirst: this.isFirstSteep,
				isLast: this.isLastStep,

				next: this.nextStep,
				back: this.backStep,
				goto: this.gotoStep
			};
		}
	},
	
	data()
	{
		return {
			show: true,
			stepIndex: this.currentStep
		};
	},

	methods: 
	{
		nextStep()
		{
			return new Promise((resolve, reject) => {
				if (!this.isLastStep)
				{
					this.gotoStep(this.stepIndex + 1)
						.then(resolve);
				}
				else
				{
					reject();
				}
			});
		},

		backStep()
		{

			return new Promise((resolve, reject) => {
				if (!this.isFirstSteep)
				{
					this.gotoStep(this.stepIndex - 1)
						.then(resolve);
				}
				else
				{
					reject();
				}
			});
		},

		gotoStep(step)
		{
			return new Promise(resolve => {
				if (this.stepsCount >= step)
				{
					this.show = false;
					this.stepIndex = step;

					this.$emit('onStep', this.scopeProps);
	
					setTimeout(() => {
						this.show = true
						resolve();
					}, 300);
				}
			});
		}
	},

	watch: {

		currentStep(val)
		{
			this.stepIndex = val;
		}

	}
};
</script>