<template>
    <span>
		<span v-if="useStocks && displayStocks.length">
			<a
				href="#"
				ref="val"
				@mouseenter="mousenterHandle"
				@mouseleave="mouseleaveHandle"
				@click.prevent
				class="d-inline-block"
			>
				<vue-quantity
					:displayMode="displayMode"
					:maxQuantity="maxQuantity"
					:relativeQuantityFactor="relativeQuantityFactor"
					:quantity="quantity"
					:measure="measure"
					:mess="mess"
				/>
			</a>

			<span v-if="useStocks && displayStocks.length" style="display: none" >
				<span class="d-block" ref="stocks">
					<span class="spinner-border" v-if="isLoading"></span>
					<span class="d-block" v-else>
						<span class="d-block" v-if="hasStocks">
							<span v-for="stock in stocks" :key="stock.id">
								<span class="d-block">
									<span class="font-weight-bold" v-html="stock.title"></span>,
									<vue-stock-value
										:displayMode="displayMode"
										:relativeQuantityFactor="relativeQuantityFactor"
										:quantity="amounts[stock.id] || 0"
										:measure="measure"
										:mess="mess"
									/>
								</span>
							</span>
						</span>
						<span class="d-block" v-else>
							{{ messages.notFound }}
						</span>
					</span>
				</span>
			</span>
		</span>
		<span v-else>
			<vue-quantity
				:displayMode="displayMode"
				:maxQuantity="maxQuantity"
				:relativeQuantityFactor="relativeQuantityFactor"
				:quantity="quantity"
				:measure="measure"
				:mess="mess"
			/>
		</span>
    </span>
</template>

<script>
import VueQuantity from './quantity.vue';
import VueStockValue from './stockvalue.vue';

export default {
	components: { VueQuantity, VueStockValue },
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
		maxQuantity:
		{
            type: Number,
            default: 999
		},
		useStocks:
		{
			type: Boolean,
			default: true
		},
		displayStocks:
		{
			type: Array,
			default: () => []
		},
		productId:
		{
			type: Number|String|Boolean,
			default: false
		},
		mess: {
			type: Object,
			default: () => {}
		},
		delay: {
			type: Number,
			default: 500
		}
	},

	data()
	{
		return {
			isPopoverAttached: false,
			isLoading: false,
			isHovered: false
		};
	},

    computed:
    {
		messages()
		{
			return Object.freeze({
				quantityRest : BX.message('RS_B2BPORTAL_STOCK_QUANTITY_REST'),
				notFound: BX.message('RS_B2BPORTAL_STOCKS_NOT_FOUND')
			});
		},

		stocks()
		{
			return this.displayStocks.length ? (
				this.displayStocks
					.filter(stockId => this.$store.state.stocks.data[stockId])
					.map(stockId => this.$store.state.stocks.data[stockId])
			) : {};
		},

		hasStocks()
		{
			return !!Object.keys(this.stocks).length;
		},

		amounts()
		{
			return this.$store.state.stocks.amounts[this.productId] || {};
		},

		amountPrints()
		{

		}
	},

	methods:
	{
		mousenterHandle()
		{
			this.isHovered = true;

			setTimeout(() => {

				if (this.isHovered)
				{
					this.popover();
				}

			}, this.delay);
		},

		mouseleaveHandle()
		{
			this.isHovered = false;
		},

		async popover()
		{
			if (this.isPopoverAttached || !this.productId)
			{
				return;
			}

			if (!$(this.$refs.val).data('bs.popover'))
			{
				$(this.$refs.val).popover({
					html: true,
					placement: 'bottom',
					content: this.$refs.stocks,
					trigger: 'hover',
					boundary: 'window'
				});
			}

			await this.$nextTick();
			$(this.$refs.val).popover('show');
			$(this.$refs.val).popover('update');

			if (!Object.keys(this.amounts).length)
			{
				this.isLoading = true;
				await this.$store.dispatch('stocks/getProductAmounts', this.productId);
				this.isLoading = false;
			}

			await this.$nextTick();
			$(this.$refs.val).popover('update');

			this.isPopoverAttached = true;
		}
	},

	watch:
	{
		productId()
		{
			this.isPopoverAttached = false;
			$(this.$refs.val).popover('dispose');
		}
	}
}
</script>
