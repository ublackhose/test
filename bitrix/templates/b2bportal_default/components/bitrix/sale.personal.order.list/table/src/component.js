export class SalePersonalOrderList
{
	constructor(el, container, data = {})
	{
		this.$el = el;
		this.$container = container;

		this.columns = data.columns || {};
		this.rows = data.rows || {};
		this.pagination = data.pagination || {};
		this.sort = data.sort || {};

		this.eventBus = new Vue();

		this.attachTemplate();
		this.handleEvents();
	}

	async sendRequest(url, data)
	{
		KTApp.block(this.$container);

		const result = await this.fetch(url, data);

		if ((result.data || {}).rows)
		{
			this.rows = result.data.rows;
			this.$template.$emit('setRows', result.data.rows);
		}

		if ((result.data || {}).pagination)
		{
			this.pagination = result.data.pagination;
			this.$template.$emit('setNav', result.data.pagination);
		}

		BX.ajax.history.put(null, url)
		
		KTApp.unblock(this.$container);

		return result;
	}

	fetch(url, data)
	{
		return new Promise((resolve, reject) => {
			BX.ajax({
				url: url,
				data: data,
				dataType: 'json',
				onsuccess: resolve,
				onfailure: reject
			});
		});
		// return fetch(url, params).then(response => response.json());
	}

	attachTemplate()
	{
		const columns = this.columns;
		const rows = this.rows;
		const pagination = this.pagination;
		const sort = this.sort;


		this.$template = new Vue({

			name: 'SalePersonalOrderList',
			
			el: this.$el,

			components: {
				'vue-table': B2BPortal.Vue.Components.VueTable
			},

			data()
			{
				return {
					columns,
					rows,
					pagination,
					sort
				}
			},

			computed: {
				messages()
				{
					return (
						Object.freeze(
							Object.keys(BX.message).filter(message => message.startsWith('SPOL'))
								.reduce((obj, message) => { obj[message.slice(message)] = BX.message(message); return obj; }, {})
						)
					);
				},
				enablePagenavigation()
				{
					return Number(this.pagination.totalRecords) > Number(this.pagination.perPage);
				},
				expandedRows()
				{
					return this.rows.reduce((indexes, row, index) => {
						if (row._IS_EXPAND) indexes.push(index);

						return indexes;
					}, []);
				},
			},

			created()
			{
				this.rows.forEach(row => this.$set(row, '_IS_EXPAND', false));
			},

			mounted()
			{
				this.$on('setRows', rows => {
					this.rows = rows.map(row => {
						this.$set(row, '_IS_EXPAND', false)
						return row;
					});
				});

				this.$on('setNav', pagination => {
					this.pagination = pagination;
				});
			},

			methods: {
				handleRowClick(params)
				{

					window.location.href = params.row.url;
				},
			},
			
			template: `
				<vue-table
					mode="remote"
					:columns="columns" 
					:rows="rows"
					:pagination-options="{
						enabled: enablePagenavigation,
						hideRowCount: true,
						setCurrentPage: pagination.currentPage,
						perPage: pagination.perPage,
						perPageDropdown: false,
					}"
					:sort-options="{
						enabled: true,
						initialSortBy: sort
					}"
					@on-sort-change="$emit('onSortChange', $event[0]);"
					@on-page-change="$emit('onPageChange', $event);"
					@on-per-page-change="$emit('onPageChange', $event);"
					:totalRows="pagination.totalRecords"
					:expandedRows="expandedRows"
				>
					<template slot="table-row" slot-scope="props">
					
						<template v-if="props.column.field === 'ID'">
							<a :href="props.row.urlToDetail">{{ props.row.accountNumber }}</a>

							<div class="d-block">
								<a href="#" class="small" @click.prevent="rows[props.index]._IS_EXPAND = !props.row._IS_EXPAND" v-if="props.row.items.length">
									{{ messages.SPOL_TPL_ORDER_LIST }}
									<i class="fa fa-angle-down" v-if="!props.row._IS_EXPAND"></i>
									<i class="fa fa-angle-up" v-else></i>
								</a>
							</div>
						</template>

						<template v-if="props.column.field === 'DATE_INSERT'">
							<a :href="props.row.urlToDetail">{{ props.row.dateInsert }}</a>
						</template>

						<template v-else-if="props.column.field === 'STATUS_ID'">
							<div v-if="props.row.status && props.row.status != ''">
								<span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--primary text-nowrap" :style="{'background-color': props.row.status.color}" v-html="props.row.status.name"></span>
							</div>
						</template>

						<template v-else-if="props.column.field === 'PRICE'">
							<div v-html="props.row.formatedPrice"></div>
						</template>

						<template v-else-if="props.column.field === 'PAYED'">
							<span v-if="props.row.payed"> <span class="">{{messages.SPOL_TPL_PAID}}</span><br>{{props.row.datePayed}} </span>
							<span v-else class="">{{ messages.SPOL_TPL_NOTPAID }}</span>
						</template>

						<template v-else-if="props.column.field === 'shipment'">
							<div v-for="(shipment, index) in props.row.shipments" :key="index">
								<span v-if="shipment.length > 1">{{shipment.deliveryName}}: </span>
								<span v-if="shipment.deducted"><span class="">{{messages.SPOL_TPL_LOADED}}</span><br>{{shipment.dateDeducted}}</span>
								<span v-else class="">{{messages.SPOL_TPL_NOTLOADED}}</span>
							</div>
						</template>

						<template v-else-if="props.column.field === 'actions'">
							<div v-if="props.row.urlToCopy && props.row.urlToCopy != ''">
								<a :href="props.row.urlToCopy">{{ messages.SPOL_TPL_REPEAT_ORDER }}</a>
							</div>
							<div v-if="props.row.canceled">
								{{ messages.SPOL_TPL_ORDER_CANCELED }} <b>{{props.row.dateCanceled}}</b>
							</div>
							<div v-else-if="props.row.urlToCancel && props.row.urlToCancel != ''">
								<a :href="props.row.urlToCancel">{{ messages.SPOL_TPL_CANCEL_ORDER }}</a>
							</div>
						</template>

						<template v-else>
							{{ props.row[props.column.field] }}
						</template>
					</template>

					<div slot="emptystate">
						<div class="text-center">{{ messages.SUP_TICKET_NOT_FOUND }}</div>
					</div>

					<template slot="expanded-row" slot-scope="props">
						<table class="table bg-white">
							<thead>
								<tr >
									<td>{{ messages.SPOL_TPL_ORDER_ITEM_NAME }}</td>
									<td>{{ messages.SPOL_TPL_ORDER_ITEM_PRICE }}</td>
									<td>{{ messages.SPOL_TPL_ORDER_ITEM_QUANTITY }}</td>
									<td>{{ messages.SPOL_TPL_ORDER_ITEM_SUM }}</td>
								</tr>
							</thead>
							<tbody>
								<tr v-for="item in props.row.items" :key="item.id">
									<td v-html="item.name"></td>
									<td v-html="item.priceFormatted"></td>
									<td>{{ item.quantity }}</td>
									<td v-html="item.sumFormatted"></td>
								</tr>
							</tbody>
						</table>
					</template>
				</vue-table>
			`
		});
	}

	handleEvents()
	{
		this.$template.$on('onSortChange', this.sorting.bind(this));
		this.$template.$on('onPageChange', this.nav.bind(this));
	}

	sorting(params)
	{
		const url = BX.util.add_url_param(window.location.href, {
			by: params.field,
			order: params.type.toUpperCase()
		});

		this.sendRequest(url);
	}

	nav(params)
	{
		const navParams = {};
		navParams[this.pagination.navName] = params.currentPage;

		const url = BX.util.add_url_param(window.location.href, navParams);
		this.sendRequest(url);
	}
}