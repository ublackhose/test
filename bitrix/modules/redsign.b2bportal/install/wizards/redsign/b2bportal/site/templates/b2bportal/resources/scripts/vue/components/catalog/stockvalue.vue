<template>
	<span>{{ printValue }}</span>
</template>

<script>

import { getRelativeQuantity } from '../../../utils';

export default {
	props:
	{
		quantity: Number,
		displayMode: {
			type: Number,
			default: 1
		},
		measure: {
			type: String,
			default: ''
		},
		relativeQuantityFactor: 
		{
			type: Number,
			default: 100
		},
		mess: {
			type: Object,
			default: () => {}
		}
	},

	computed:
	{
		messages()
		{
			return Object.freeze({
				quantityRest : BX.message('RS_B2BPORTAL_STOCK_QUANTITY_REST')
			});
		},

		printValue()
		{
			let value;

			switch(this.displayMode)
			{
				case 1:
					value = `${this.messages.quantityRest} ${this.quantity} ${this.measure}`;
					break;
				case 2:
				default:
					value = getRelativeQuantity(
						this.quantity,
						this.relativeQuantityFactor,
						this.mess
					);

					break;
			}

			return value;
		},
	}
}
</script>
