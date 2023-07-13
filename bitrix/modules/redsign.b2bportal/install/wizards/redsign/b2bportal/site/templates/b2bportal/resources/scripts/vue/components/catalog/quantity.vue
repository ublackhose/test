<template>
    <span
        class="kt-badge kt-badge--inline kt-badge--pill text-nowrap"
        :class="badgeColor"
    >
        {{ printValue }}
    </span>
</template>

<script>

import { getRelativeQuantity } from '../../../utils';

export default {
    props:
    {
		quantity: Number,
		displayMode:
		{
			type: Number,
			default: 1
		},
		measure:
		{
			type: String,
			default: ''
		},
        relativeQuantityFactor:
		{
            type: Number,
            default: 100
        },
        maxQuantity: {
            type: Number,
            default: 999
		},
		mess: {
			type: Object,
			default: () => {}
		}
    },

    computed:
    {
        printValue()
        {
			let value;

			switch(this.displayMode)
			{
				case 1:
					if (this.quantity > this.maxQuantity)
					{
						value = `${this.maxQuantity}+ ${this.measure}`;
					}
					else
					{
						value = `${this.quantity} ${this.measure}`;
					}

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

        badgeColor()
        {
            let badgeColor = 'danger';

            if (this.quantity > this.relativeQuantityFactor)
            {
                badgeColor = 'success';
            }
            else if (this.quantity <= this.relativeQuantityFactor && this.quantity > 0)
            {
                badgeColor = 'warning';
            }

            return `kt-badge--${badgeColor}`;
        }
	}
}
</script>
