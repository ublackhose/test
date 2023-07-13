import { Vue } from 'ui.vue';
import VueProductTableRow from './vue-product-table-row.js';

export default {

	components: { VueProductTableRow },

	props: {
		rows: Array
	},

	computed: {
		messages()
		{
			return Vue.getFilteredPhrases('RS_KP_EDITOR_');
		},
		currency()
		{
			return  (this.rows[0] || {}).currency;
		},
		prices()
		{
			return this.rows.map(row => row.price * row.quantity);
		},
		total()
		{
			return this.prices.reduce((sum, price) => sum + price, 0);
		},
		totalFormatted()
		{
			return BX.Currency.currencyFormat(this.total, this.currency, true); 
		}
	},

	methods: {
		en(s)
		{
			const e = document.createElement('div');
			e.innerHTML = s;
			return e.innerText;
		}
	},

	template: `
		<div>
			<table class="rskp-e-pt">
				<thead>
					<tr>
						<th class="rskp-e-pt__col rskp-e-pt__col--name">
							{{ messages.RS_KP_EDITOR_PRODUCT_TABLE_COL_NAME }}
						</th>
						<th class="rskp-e-pt__col rskp-e-pt__col--price">
							{{ messages.RS_KP_EDITOR_PRODUCT_TABLE_COL_PRICE }}
						</th>
						<th class="rskp-e-pt__col rskp-e-pt__col--quantity">
							{{ messages.RS_KP_EDITOR_PRODUCT_TABLE_COL_QUANTITY }}
						</th>
						<th class="rskp-e-pt__col rskp-e-pt__col--sum">
							{{ messages.RS_KP_EDITOR_PRODUCT_TABLE_COL_SUM }}
						</th>
					</tr>
				</thead>
				<tbody>
					<VueProductTableRow
						v-for="(row, index) in rows"
						:key="index"
						:row="row"
					/>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3" class="rskp-e-pt__col rskp-e-pt__col--total">
							{{ messages.RS_KP_EDITOR_PRODUCT_SUMMARY_COUNT }}
						</td>
						<td class="rskp-e-pt__col rskp-e-pt__col--sum">
						{{ rows.length }}
						</td>
					</tr>
					<tr>
						<td colspan="3" class="rskp-e-pt__col rskp-e-pt__col--total">
							{{ messages.RS_KP_EDITOR_PRODUCT_SUMMARY_TOTAL }}
						</td>
						<td class="rskp-e-pt__col rskp-e-pt__col--sum" :title="en(totalFormatted)">
							<span> {{ en(totalFormatted) }} </span>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	`
};