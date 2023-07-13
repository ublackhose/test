import { addUrlParams } from './utils';

export class SupportTicketList
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
					return Object.freeze({
						'SUP_TICKET_NOT_FOUND': BX.message('SUP_TICKET_NOT_FOUND')
					});
				}
			},

			mounted()
			{
				this.$on('setRows', rows => {
					this.rows = rows;
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
						enabled: true,
						hideRowCount: true,
						setCurrentPage: pagination.currentPage,
						perPage: pagination.perPage,
						perPageDropdown: false,
					}"
					:sort-options="{
						enabled: true,
						initialSortBy: sort
					}"
					@on-row-click="handleRowClick"
					@on-sort-change="$emit('onSortChange', $event[0]);"
					@on-page-change="$emit('onPageChange', $event);"
					@on-per-page-change="$emit('onPageChange', $event);"
					:totalRows="pagination.totalRecords"
				>
					<template slot="table-row" slot-scope="props">

						<template v-if="props.column.field === 's_id'">
							<div><a :href="props.row.url">#{{props.row[props.column.field]}}</a></div>
							<div class="text-muted">{{props.row.created}}</div>
						</template>

						<template v-else-if="props.column.field === 's_title'">
							<a :href="props.row.url">{{props.row[props.column.field]}}</a>
						</template>

						<template v-else>
							<div v-html="props.row[props.column.field]"></div>
						</template>
					</template>

					<div slot="emptystate">
						<div class="text-center">{{ messages.SUP_TICKET_NOT_FOUND }}</div>
					</div>
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
		const url = addUrlParams(window.location.pathname, {
			by: params.field,
			order: params.type
		});

		this.sendRequest(url);
	}

	nav(params)
	{
		const navParams = {};
		navParams[this.pagination.navName] = params.currentPage;

		const url = addUrlParams(window.location.href, navParams);
		this.sendRequest(url);
	}
}