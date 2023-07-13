<template>
	<tree-table :rows="rows" :columns="columns">

		<template v-slot:beforeRows="scope">
			<tr class="kt-datatable__row">
				<td class="kt-datatable__cell">
					<b>{{ messages['CATALOG'] }}</b>
				</td>
				<td class="kt-datatable__cell"></td>
				<td class="kt-datatable__cell">
					<div style="width: 150px;">
						<div class="input-group input-group-sm">
							<input 
								ref="catalogExtra"
								tabindex="1" 
								name="extra_persent" 
								class="form-control"
								type="number"
								value="0"
								min="-100"
								step="any"
								@change="updateExtra(null, $event)"
							>
							<div class="input-group-append"><span class="input-group-text">%</span></div>
						</div>
					</div>
				</td>
			</tr>
		</template>
		
		<template v-slot:name="scope">
			<div style="width: 367px;" :style="{ 'padding-left': 25 * (scope.row.DEPTH_LEVEL - 1) + 'px' }">
				<a  
					class="mr-3 collapsed"
					href="#"
					v-if="(scope.row.CHILDREN || []).length"
					@click.prevent="scope.toggleRow(scope.row)"
				>
					<i :class="{'flaticon2-right-arrow': !scope.row.IS_EXPAND, 'flaticon2-down-arrow': scope.row.IS_EXPAND}"></i>
				</a>
				{{ scope.row.NAME }}
			</div>
		</template>

		<template v-slot:extra="scope">
			{{ (scope.row._EXTRA[priceId] || {}).VALUE || 0 }}%
		</template>

		<template v-slot:edit_extra="scope">
			<div style="width: 150px;">
				<div class="input-group input-group-sm">
					<input 
						tabindex="1" 
						name="extra_persent" 
						class="form-control"
						type="number"
						min="-100"
						step="any"
						:value="(scope.row.EXTRA[priceId] || {}).VALUE"
						@change="updateExtra(scope.row, $event)"
					>
					<div class="input-group-append"><span class="input-group-text">%</span></div>
				</div>
			</div>
		</template>

	</tree-table>
</template>

<script>
import _cloneDeep from 'lodash/cloneDeep';
import TreeTable from '../treetable.vue';

export default {

	components: {
		TreeTable
	},
	
	props: {
		rows: Array,
		columns: Array,
		messages: Object,
		priceId: {
			type: Number,
			default: 1
		}
	},

	data()
	{
		return {}
	},

	methods: {

		initRows(rows)
		{
			rows.forEach((row, index) => {

				if ((row.CHILDREN || []).length)
				{
					this.initRows(row.CHILDREN);
				}
				
				this.$set(row, 'EXTRA', row.EXTRA);
			});
		},
		
		setExtraValue(row, value)
		{
			this.$emit('setExtraValue', {
				row,
				newValue: value,
				oldValue: row._EXTRA[this.priceId].VALUE,
				priceId: this.priceId
			});

			if (!row.EXTRA[this.priceId])
			{
				row.EXTRA[this.priceId] = {
					VALUE: 0,
					PRICE_ID: this.priceId
				};
			}

			row.EXTRA[this.priceId].VALUE = value;            


			if ((row.CHILDREN || []).length)
			{
				row.CHILDREN.forEach(childRow => {
					this.setExtraValue(childRow, value);
				});
			}
		},

		updateExtra(parentRow, $event)
		{   
			var value = parseFloat($event.target.value);
			
			if (isNaN(value))
			{
				value = $event.target.value = 0;
			}

			if (parentRow)
			{
				if ((parentRow.CHILDREN || []).length == 0 || confirm(this.messages['CONFIRM_SET_EXTRA']))
				{
					this.setExtraValue(parentRow, value);
				}
				else
				{
					$event.target.value = parentRow.EXTRA[this.priceId].VALUE;
				}
			}
			else
			{
				if (confirm(this.messages['CONFIRM_SET_EXTRA_CATALOG']))
				{
					this.rows.forEach((row) => this.setExtraValue(row, value))
				}
			}
		},
	},

	watch: {
		priceId()
		{
			this.$refs.catalogExtra.value = 0;
		}
	},

	beforeMount()
	{
		this.initRows(this.rows);
	}
};
</script>