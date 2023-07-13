<template>
	<div
		class="vgt-wrap"
		:class="{
		'rtl': rtl,
		'nocturnal': theme==='nocturnal',
		'black-rhino': theme==='black-rhino',
	}">
		<div v-if="isLoading" class="vgt-loading vgt-center-align">
			<slot name="loadingContent">
				<span class="vgt-loading__content">
					Loading...
				</span>
			</slot>
		</div>
		<div
			class="vgt-inner-wrap"
			:class="{'is-loading': isLoading}">
			<slot
				v-if="paginate && paginateOnTop"
				name="pagination-top"
				:pageChanged="pageChanged"
				:perPageChanged="perPageChanged"
				:total="totalRows || totalRowCount"
			>
				<vgt-pagination
					ref="paginationTop"
					@page-changed="pageChanged"
					@per-page-changed="perPageChanged"
					:perPage="perPage"
					:rtl="rtl"
					:total="totalRows || totalRowCount"
					:mode="paginationMode"
					:nextText="nextText"
					:prevText="prevText"
					:rowsPerPageText="rowsPerPageText"
					:customRowsPerPageDropdown="customRowsPerPageDropdown"
					:paginateDropdownAllowAll="paginateDropdownAllowAll"
					:ofText="ofText"
					:pageText="pageText"
					:allText="allText"
				></vgt-pagination>
			</slot>
			<vgt-global-search
				@on-keyup="searchTableOnKeyUp"
				@on-enter="searchTableOnEnter"
				v-model="globalSearchTerm"
				:search-enabled="searchEnabled && externalSearchQuery == null"
				:global-search-placeholder="searchPlaceholder"
			>
				<template slot="internal-table-actions">
				<slot name="table-actions">
				</slot>
				</template>
			</vgt-global-search>
			<div
				v-if="selectedRowCount"
				class="vgt-selection-info-row clearfix"
				:class="selectionInfoClass"
			>
				{{selectionInfo}}
				<a
					href=""
					@click.prevent="unselectAllInternal(true)"
				>
					{{clearSelectionText}}
				</a>
				<div class="vgt-selection-info-row__actions vgt-pull-right">
					<slot name="selected-row-actions">
					</slot>
				</div>
			</div>
			<div class="vgt-fixed-header">
				<table
				v-if="fixedHeader"
				:class="tableStyleClasses"
				>
					<!-- Table header -->
					<thead
						is="vgt-table-header"
						ref="table-header-secondary"
						@on-toggle-select-all="toggleSelectAll"
						@on-sort-change="changeSort"
						@filter-changed="filterRows"
						:columns="columns"
						:line-numbers="lineNumbers"
						:selectable="selectable"
						:all-selected="allSelected"
						:all-selected-indeterminate="allSelectedIndeterminate"
						:mode="mode"
						:sortable="sortable"
						:typed-columns="typedColumns"
						:getClasses="getClasses"
						:searchEnabled="searchEnabled"
						:paginated="paginated"
						:table-ref="$refs.table"
					>
						<template
						slot="table-column"
						slot-scope="props"
						>
						<slot
							name="table-column"
							:column="props.column"
						>
							<span>{{props.column.label}}</span>
						</slot>
						</template>
					</thead>
				</table>
			</div>
			<div
				:class="{'vgt-responsive': responsive}"
				:style="wrapperStyles"
			>
				<table
				ref="table"
				:class="tableStyleClasses"
				>
				<!-- Table header -->
					<thead
						is="vgt-table-header"
						ref="table-header-primary"
						@on-toggle-select-all="toggleSelectAll"
						@on-sort-change="changeSort"
						@filter-changed="filterRows"
						:columns="columns"
						:line-numbers="lineNumbers"
						:selectable="selectable"
						:all-selected="allSelected"
						:all-selected-indeterminate="allSelectedIndeterminate"
						:mode="mode"
						:sortable="sortable"
						:typed-columns="typedColumns"
						:getClasses="getClasses"
						:searchEnabled="searchEnabled"
					>
						<template
							slot="table-column"
							slot-scope="props"
						>
							<slot
								name="table-column"
								:column="props.column"
							>
								<span>{{props.column.label}}</span>
							</slot>
						</template>
					</thead>

					<!-- Table body starts here -->
					<tbody
						v-for="(headerRow, index) in paginated"
						:key="index"
					>
						<!-- if group row header is at the top -->
						<vgt-header-row
							v-if="groupHeaderOnTop"
							:header-row="headerRow"
							:columns="columns"
							:line-numbers="lineNumbers"
							:selectable="selectable"
							:collect-formatted="collectFormatted"
							:formatted-row="formattedRow"
							:get-classes="getClasses"
							:full-colspan="fullColspan"
						>
							<template
								v-if="hasHeaderRowTemplate"
								slot="table-header-row"
								slot-scope="props"
							>
								<slot
								name="table-header-row"
								:column="props.column"
								:formattedRow="props.formattedRow"
								:row="props.row"
								>
								</slot>
							</template>
						</vgt-header-row>
						<!-- normal rows here. we loop over all rows -->
						<template v-for="(row, index) in headerRow.children">
							<tr
								:key="row.originalIndex"
								:class="getRowStyleClass(row)"
								ref="rows"
								@mouseenter="onMouseenter(row, index)"
								@mouseleave="onMouseleave(row, index)"
								@dblclick="onRowDoubleClicked(row, index, $event)"
								@click="onRowClicked(row, index, $event)"
								@auxclick="onRowAuxClicked(row, index, $event)"
							>
								<th
									v-if="lineNumbers"
									class="line-numbers"
								>
									{{ getCurrentIndex(index) }}
								</th>
								<th
									v-if="selectable"
									class="vgt-checkbox-col"
								>
									<label
									class="vgt-checkbox-label kt-checkbox kt-checkbox--single kt-checkbox--solid"
									@click.stop
									>
										<input
											type="checkbox"
											:checked="row.vgtSelected"
											@click.stop="onCheckboxClicked(row, index, $event)"
										/>
										<span></span>
									</label>
								</th>
								<td
									@click="onCellClicked(row, column, index, $event)"
									v-for="(column, i) in columns"
									:key="i"
									:class="getClasses(i, 'td', row)"
									v-if="!column.hidden && column.field"
								>
									<slot
										name="table-row"
										:row="row"
										:column="column"
										:formattedRow="formattedRow(row)"
										:index="index"
									>
										<span v-if="!column.html">
											{{ collectFormatted(row, column) }}
										</span>
										<span
											v-if="column.html"
											v-html="collect(row, column.field)"
										>
										</span>
									</slot>
								</td>
							</tr>
							<tr v-if="isExpanded(row)" :key="row.originalIndex + '-expanded'" class="vgt-row-expanded">
								<td :colspan="fullColspan">
									<slot
										name="expanded-row"
										:row="row"
										:formattedRow="formattedRow(row)"
										:index="index"
									></slot>
								</td>
							</tr>
						</template>

						<!-- if group row header is at the bottom -->
						<vgt-header-row
							v-if="groupHeaderOnBottom"
							:header-row="headerRow"
							:columns="columns"
							:line-numbers="lineNumbers"
							:selectable="selectable"
							:collect-formatted="collectFormatted"
							:formatted-row="formattedRow"
							:get-classes="getClasses"
							:full-colspan="fullColspan"
						>
							<template
								v-if="hasHeaderRowTemplate"
								slot="table-header-row"
								slot-scope="props"
							>
								<slot
									name="table-header-row"
									:column="props.column"
									:formattedRow="props.formattedRow"
									:row="props.row"
								>
								</slot>
							</template>
						</vgt-header-row>
					</tbody>

					<tbody v-if="showEmptySlot">
						<tr>
							<td :colspan="fullColspan">
								<slot name="emptystate">
									<div class="vgt-center-align vgt-text-disabled">
										{{ messages.NO_DATA_FOR_TABLE }}
									</div>
								</slot>
							</td>
						</tr>
					</tbody>

				</table>
			</div>
			<div v-if="hasFooterSlot" class="vgt-wrap__actions-footer">
				<slot name="table-actions-bottom">
				</slot>
			</div>
			<slot
				v-if="paginate && paginateOnBottom"
				name="pagination-bottom"
				:pageChanged="pageChanged"
				:perPageChanged="perPageChanged"
				:total="totalRows || totalRowCount"
			>
				<vgt-pagination
					ref="paginationBottom"
					@page-changed="pageChanged"
					@per-page-changed="perPageChanged"
					:perPage="perPage"
					:rtl="rtl"
					:total="totalRows || totalRowCount"
					:mode="paginationMode"
					:nextText="nextText"
					:prevText="prevText"
					:rowsPerPageText="rowsPerPageText"
					:customRowsPerPageDropdown="customRowsPerPageDropdown"
					:paginateDropdownAllowAll="paginateDropdownAllowAll"
					:ofText="ofText"
					:pageText="pageText"
					:allText="allText"
					:hideRowCount="hideRowCount"
				></vgt-pagination>
			</slot>
		</div>
	</div>
</template>

<script>
import VgtPagination from './VgtPagination.vue';
import VgtTableHeader from './VgtTableHeader.vue';
import { VueGoodTable } from 'vue-good-table';

export default {

	extends: VueGoodTable,

	name: 'vue-table',

	props: {
		expandedRows: {
			type: Array,
			default: () => []
		}
	},

	methods: {
		getRowStyleClass(row)
		{
			let classes = '';

			if (this.hasRowClickListener) classes += 'clickable';

			if (row.vgtSelected) classes += ' vgt-row--selected';

			let rowStyleClasses;

			if (typeof this.rowStyleClass === 'function')
			{
				rowStyleClasses = this.rowStyleClass(row);
			}
			else
			{
				rowStyleClasses = this.rowStyleClass;
			}

			if (rowStyleClasses)
			{
				classes += ` ${rowStyleClasses}`;
			}

			return classes;
		},

		onCheckboxClicked(row, index, event)
		{
			if (
				event.shiftKey &&
				this.lastSelectedRow &&
				this.lastSelectedRow.originalIndex !== index
			)
			{
				const s = !row.vgtSelected;
				if (index > this.lastSelectedRow.originalIndex)
				{
					this.processedRows.forEach(group => {
						group.children
							.filter(r => r.originalIndex >= this.lastSelectedRow.originalIndex && r.originalIndex <= index)
							.forEach(r => {
								this.$set(r, 'vgtSelected', s);
								this.$emit('on-row-click', {
									r,
									pageIndex: index,
									selected: s,
									event,
								});
							})
					});
				} 
				else
				{
					this.processedRows.forEach(group => {
						group.children
							.filter(r => r.originalIndex >= index && r.originalIndex <= this.lastSelectedRow.originalIndex)
							.forEach(r => {
								this.$set(r, 'vgtSelected', s);
								this.$emit('on-row-click', {
									r,
									pageIndex: index,
									selected: s,
									event,
								});
							})
					});
				}
			}
			else
			{
				this.$set(row, 'vgtSelected', !row.vgtSelected);
				this.$emit('on-row-click', {
					row,
					pageIndex: index,
					selected: !!row.vgtSelected,
					event,
				});
			}

			this.lastSelectedRow = row;
		}

	},

	data()
	{
		return {
			selectOnCheckboxOnly: true,
			paginateDropdownAllowAll: false,
			lastSelectedRowIndex: undefined
		}
	},

	computed: {

		isExpanded()
		{
			return row => {
				return this.expandedRows.includes(row.originalIndex);
			};
		},

		hideRowCount()
		{
			return this.paginationOptions.hideRowCount || false;
		},

		messages()
		{
			return Object.freeze({
				'NO_DATA_FOR_TABLE': BX.message('VUE.VGT_PAGINATION.NO_DATA_FOR_TABLE'),
			})
		},

	},

	components: {
		'vgt-pagination': VgtPagination,
		'vgt-table-header': VgtTableHeader,
		'vue-good-table': VueGoodTable,
	},

}
</script>