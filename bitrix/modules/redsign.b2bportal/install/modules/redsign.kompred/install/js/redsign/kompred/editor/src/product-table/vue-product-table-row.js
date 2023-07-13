import { CurrencyInput } from 'vue-currency-input';
import { Vue } from 'ui.vue';

export default {

	components: { CurrencyInput },

	props: {
		row: Object,
	},

	computed: {
		messages()
		{
			return Vue.getFilteredPhrases('RS_KP_EDITOR_PRODUCT_TABLE_');
		},
		currency()
		{
			return this.row.currency
		},
		currencyFormat()
		{
			const currencyFormat = BX.Currency.getCurrencyFormat(this.currency);
			if (currencyFormat)
			{
				const format = this.en(currencyFormat.FORMAT_STRING);
				const formatSplit = format.split('#');

				return {
					prefix: formatSplit[0],
					suffix: formatSplit[1]
				};
			}

			return this.row.currency;
		},
		sum()
		{
			return Math.round((this.row.price * this.row.quantity + Number.EPSILON) * 100) / 100;
		},
		sumFormatted()
		{
			return BX.Currency.currencyFormat(this.sum, this.currency, true);
		}
	},

	methods: {
		en(str)
		{
			const a = document.createElement('div');
			a.innerHTML = str;
			return a.innerText;
		}
	},

	template: `
		<tr>
			<td class="rskp-e-pt__col rskp-e-pt__col--name">
				<div class="rskp-e-pt__name">{{ en(row.name) }}</div>
				<div class="rskp-e-pt__code" v-if="row.vendorCode">
					{{ messages.RS_KP_EDITOR_PRODUCT_TABLE_VENDOR_CODE }} {{ en(row.vendorCode) }}
				</div>
			</td>
			<td class="rskp-e-pt__col rskp-e-pt__col--price">
				<CurrencyInput 
					class="form-control form-control-sm"
					v-model="row.price"
					:currency="currencyFormat"
					:allow-negative="false"
					:precision="{
						min: 0,
						max: 2
					}"
					:distraction-free="{
						hideGroupingSymbol: false,
						hideCurrencySymbol: true,
						hideNegligibleDecimalDigits: true
					}"
				/>
			</td>
			<td class="rskp-e-pt__col rskp-e-pt__col--quantity">
				<div class="input-group input-group-sm">
					<input 
						class="form-control form-control-sm"
						type="number" 
						v-model="row.quantity"
						:step="row.ratio"
						:min="row.ratio"
						tabindex="2"
					>
					<div class="input-group-append">
						<span class="input-group-text">{{ row.measureName }}</span>
					</div>
				</div>
			</td>
			<td class="rskp-e-pt__col rskp-e-pt__col--sum" :title="en(sumFormatted)">
				<span>{{ en(sumFormatted) }}</span>
			</td>
		</tr>
	`
};