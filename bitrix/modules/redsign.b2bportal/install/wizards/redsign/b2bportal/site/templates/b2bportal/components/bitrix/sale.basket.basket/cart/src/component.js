import BasketSummary from './BasketSummary.vue';
import BasketTable from './BasketTable.vue';
import BasketTableActions from './BasketTableActions.vue';

const { store } = B2BPortal;

const NOTIFY_DEFAULT_OPTIONS = {
	extendedTimeOut: 5000,
	progressBar: true,
	tapToDismiss: false,
};

const sendNotify = (status, message, options) => window.toastr[status](message, '', Object.assign(NOTIFY_DEFAULT_OPTIONS, options));

const getRemoveRequestData = (ids) => {
	return ids.reduce((data, id) => {
		data['DELETE_' + id] = 'Y';

		return data;
	}, {});
};

const getRestoreRequestData = (ids, rows) => {
	return ids.reduce((data, id) => {

		if (rows[id])
		{
			data['RESTORE_' + id] = {
				'PRODUCT_ID': rows[id].PRODUCT_ID,
				'QUANTITY': rows[id].QUANTITY,
				'PROPS': rows[id].PROPS_ALL,
				'SORT': rows[id].SORT,
				'MODULE': rows[id].MODULE,
				'PRODUCT_PROVIDER_CLASS': rows[id].PRODUCT_PROVIDER_CLASS
			};
		}

		return data;
	}, {});
};

export class Basket
{
	constructor(params)
	{
		this.elementId = params.elementId;
		this.$el = params.elementId ? document.getElementById(params.elementId) : document.createElement('div');
		this.$searchInput = params.searchInput;

		this.columns = params.columns || [];
		this.rows = params.rows || [];
		this.summary = params.summary || [];

		this.showQuantity = params.showQuantity;
		if (this.showQuantity)
		{
			this.quantityDisplayMode = params.quantityDisplayMode;
			this.quantityRelativeFactor = params.quantityRelativeFactor;
			this.quantityMessages = params.quantityMessages;
			this.useStocks = params.useStocks;
			this.displayStocks = params.displayStocks;
			this.maxQuantity = params.maxQuantity;
		}

		this.groupedRows = {};
		this.rows.forEach(row => {
			this.groupedRows[row.ID] = row;
		});

		this.selectedRows = [];

		this.pathToOrder = params.pathToOrder || '';
		this.signedParameters = params.signedParameters || '';
		this.signedTemplate = params.template || '';
		this.siteId = params.siteId || '';
		this.siteTemplateId = params.siteTemplateId || '';
		this.actionVariable = params.actionVariable || basketAction;
		this.ajaxUrl = params.ajaxUrl || '/bitrix/components/bitrix/sale.basket.basket/ajax.php';
		this.exportTypes = params.exportTypes;

		this.discountList = params.discountList || [];

		this.eventBus = new Vue();


		this.handleEvents();

		this.attachTemplate();
		this.attachActions();
		this.attachSummary();
		this.checkTools();
	}

	handleEvents()
	{
		this.$searchInput.addEventListener('input', (e) => {
			this.eventBus.$emit('inputSearchQuery', e.target.value);
		});

		this.eventBus.$on('updateItemQuantity', this.updateItemQuantity.bind(this));
		this.eventBus.$on('removeItem', this.removeItem.bind(this));
		this.eventBus.$on('removeSelectedItems', this.removeSelectedItems.bind(this));
		this.eventBus.$on('moveItem', this.moveItem.bind(this));
		this.eventBus.$on('moveSelectedItems', this.moveSelectedItems.bind(this));
		this.eventBus.$on('selectedRowsChange', this.selectedRowsChange.bind(this));

		BX.addCustomEvent('updateBasketComponent', this.recalculate.bind(this));
	}


	async updateItemQuantity({itemId, productId, quantity})
	{
		const requestData = {
			basket: {}
		};

		requestData.basket['QUANTITY_' + itemId] = quantity;

		const result = await this.sendRequest(requestData);
		this.applyBasketData(result.BASKET_DATA);

		store.commit('cart/SET_QUANTITY', {
			itemId: Number(productId),
			quantity: Number(quantity)
 		});

		store.dispatch('cart/fetch');
	}

	selectedRowsChange(rows)
	{
		this.selectedRows = rows;
	}

	async removeItem(itemId)
	{
		this.showLoading()

		this.removeItems( [itemId] );

		this.hideLoading()
	}

	async removeSelectedItems()
	{
		this.showLoading()

		if (this.selectedRows.length > 0)
		{
			this.removeItems(this.selectedRows.map(row => row.ID));
		}

		this.hideLoading()
	}


	async moveItem(productId, toBasketCode)
	{
		this.showLoading()

		this.moveItems([productId], toBasketCode);

		this.hideLoading()
	}

	async moveSelectedItems(toBasketId)
	{
		this.showLoading()

		if (this.selectedRows.length > 0)
		{
			this.moveItems(this.selectedRows.map(row => row.PRODUCT_ID), toBasketId);
		}

		this.hideLoading()
	}

	async moveItems(productIds, toBasketCode)
	{
		try
		{
			const result = await new Promise((resolve, reject) => {
				BX.ajax.runAction('redsign:vbasket.api.userbasket.moveMultiple', {
					data: {
						productIds: productIds,
						toBasketCode: toBasketCode
					}
				}).then(resolve, reject);
			});

			const resultData = result.data;

			const successItems = resultData.filter(item => item.isSuccess);
			const successIds = successItems.map(item => item.productId);

			const failedItems = resultData.filter(itemStatus => !itemStatus.isSuccess);
			const failedIds = failedItems.map(item => item.productId);

			this.deleteRowsByFieldValues('PRODUCT_ID', successIds);
			this.checkTools();

			if (successIds.length)
			{
				sendNotify(
					'success',
					successIds.length === 1 ?
						BX.message('SBB_GOOD_SUCCESS_MOVED') : BX.message('SBB_GOODS_SUCCESS_MOVED')
				);
			}

			if (failedIds.length)
			{
				sendNotify(
					'success',
					BX.message('SBB_GOODS_FAIL_MOVED')
				);
			}

			if (B2BPortal.store)
			{
				B2BPortal.store.dispatch('fetchBasket');
				store.dispatch('cart/fetch');
			}
		}
		catch (e)
		{
			console.error(e)
			window.toastr.error((e.errors || [{}])[0].message);
		}
	}

	async removeItems(ids)
	{
		const basketData = getRemoveRequestData(ids);

		try
		{
			const result = await this.sendRequest({
				basket: basketData
			});

			const deletedIds = result.DELETED_BASKET_ITEMS;


			if (deletedIds.length === 0)
			{
				// throw new Error([
				// 	{
				// 		message: ''
				// 	}
				// ]);
			}

			this.rows.filter(row => deletedIds.includes(Number(row.ID)))
				.forEach(row => {
					store.commit('cart/REMOVE_ITEM_FROM_CART', {
						itemId: Number(row.PRODUCT_ID)
					});
				});


			this.applyBasketData(result.BASKET_DATA);
			this.deleteRowsByIds(deletedIds);
			this.checkTools();

			sendNotify(
				'success',
				deletedIds.length === 1 ?
					BX.message('SBB_BASKET_ITEM_DELETED').replace('#NAME#', this.groupedRows[deletedIds[0]].NAME) :
					BX.message('SBB_BASKET_ITEMS_DELETED'),
				{
					onclick: e =>
					{
						if (e.target.tagName == 'A')
						{
							e.preventDefault();
							this.restoreItems(deletedIds);
						}

						window.toastr.clear($(e.target).closest('.toast'), { force: true });
					}
				}
			);

			store.dispatch('fetchBasket');
			store.dispatch('cart/fetch');

		}
		catch (e)
		{
			console.warn(e);
			window.toastr.error(e);
		}
	}

	async restoreItems(ids)
	{
		const basketData = getRestoreRequestData(ids, this.groupedRows);

		try
		{
			const result = await this.sendRequest({
				basket: basketData
			});

			for (let restoredItemId in result.RESTORED_BASKET_ITEMS)
			{
				if (result.RESTORED_BASKET_ITEMS.hasOwnProperty(restoredItemId))
				{
					this.addRow(
						result.BASKET_DATA.ROWS.find(row =>
							 row.ID == result.RESTORED_BASKET_ITEMS[restoredItemId]
						)
					);
				}
			}

			sendNotify('info', BX.message('SBB_BASKET_ITEM_RESTORED'));

			if (B2BPortal.store)
			{
				B2BPortal.store.dispatch('fetchBasket');
				store.dispatch('cart/fetch');
			}
		}
		catch (e)
		{
			console.warn(e);
			sendNotify('error', BX.message('SBB_BASKET_RESTORE_FAIL'));
		}
	}

	applyBasketData(data)
	{
		if (data.ROWS && data.ROWS.length > 0)
		{
			data.ROWS.forEach((row) => {

				if (this.groupedRows[row.ID])
				{
					this.assignRow(this.groupedRows[row.ID], row);
				}
				else
				{
					this.addRow(row);
				}

			});
		}

		if (data.SUMMARY)
		{
			this.assignRow(this.summary, data.SUMMARY);
		}

		if (data.FULL_DISCOUNT_LIST)
			this.discountList = data.FULL_DISCOUNT_LIST;
	}

	assignRow(targetRow, sourceRow)
	{
		Object.assign(targetRow, sourceRow);
	}

	addRow(row)
	{
		this.rows.push(row);
		this.groupedRows[row.ID] = row;
	}

	deleteRowsByFieldValues(fieldName, values)
	{
		values.forEach(value => this.deleteRowByIndex(this.rows.findIndex(row => row[fieldName] == value)));
	}

	deleteRowsByIds(ids)
	{
		ids.forEach(id => this.deleteRowByIndex(this.rows.findIndex(row => row.ID == id)));
	}

	deleteRowByIndex(index)
	{
		this.rows.splice(index, 1);
	}

	checkTools()
	{
		const pdfLink = document.querySelector(`#pdflink_${this.elementId}`);

		if (pdfLink)
		{
			if (this.rows.length > 0)
			{
				pdfLink.classList.remove('disabled');
			}
			else
			{
				pdfLink.classList.add('disabled');
			}
		}
	}

	async recalculate()
	{
		this.showLoading()

		const result = await this.sendRequest();
		this.applyBasketData(result.BASKET_DATA);
		this.checkTools();

		this.hideLoading()
	}

	sendRequest(data)
	{
		const requestData = Object.assign({}, data);

		requestData[this.actionVariable] = 'recalculateAjax';
		requestData.signedParamsString = this.signedParameters;
		requestData.template = this.signedTemplate;
		requestData.via_ajax = 'Y';
		requestData.sessid = BX.bitrix_sessid();

		requestData.site_id = this.siteId;
		requestData.site_template_id = this.siteTemplateId;
		requestData.lastAppliedDiscounts = BX.util.array_keys(this.discountList).join(',');

		return new Promise((resolve, reject) => {
			BX.ajax({
				method: 'POST',
				dataType: 'json',
				url: this.ajaxUrl,
				data: requestData,
				onsuccess: resolve,
				onfailure: reject
			});
		});
	}

	attachActions()
	{
		const eventBus = this.eventBus;

		const template = (element) => new Vue({
			el: element,

			components: { BasketTableActions },

			data()
			{
				return {
					disabled: true,
					messages: Object.freeze({
						ACTIONS: BX.message('SBB_ACTIONS')
					})
				};
			},

			mounted()
			{
				eventBus.$on('selectedRowsChange', selectedRows => {
					this.disabled = selectedRows.length === 0;
				});
			},

			methods: {

				remove()
				{
					eventBus.$emit('removeSelectedItems');
				},

				move(toBasket)
				{
					eventBus.$emit('moveSelectedItems', toBasket.CODE);
				}

			},

			template: `
			<div class="dropdown">
				<a data-toggle="dropdown" data-boundary="viewport" role="button" href="#" class="btn btn-default" :class="{disabled: disabled}">
					<i class="flaticon2-soft-icons"></i> {{ messages.ACTIONS }}
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<BasketTableActions :disabled="disabled" @remove="remove" @move="move" />
				</div>
			</div>
			`
		});

		this.actionsHead = template(document.getElementById(this.elementId + '_actionsHead'));
		this.actionsFoot = template(document.getElementById(this.elementId + '_actionsFoot'));
	}

	attachTemplate()
	{
		const eventBus = this.eventBus;
		const columns = this.columns;
		const rows = this.rows;

		const params = {
			showQuantity: this.showQuantity
		};

		if (this.showQuantity)
		{
			params.quantityDisplayMode = this.quantityDisplayMode;
			params.quantityRelativeFactor = this.quantityRelativeFactor;
			params.quantityMessages = this.quantityMessages;
			params.useStocks = this.useStocks;
			params.displayStocks = this.displayStocks;
			params.maxQuantity = this.maxQuantity;
		}

		this.template = new Vue({
			el: this.$el,
			components: { BasketTable },
			store: B2BPortal.store,

			data()
			{
				return {
					columns,
					rows,
					params,
					eventBus
				}
			},

			template: `<BasketTable :columns="columns" :rows="rows" :params="params" />`
		});
	}

	attachSummary()
	{
		const $element = document.getElementById(this.elementId + '_summary');
		const summary = this.summary;
		const pathToOrder = this.pathToOrder;
		const exportTypes = this.exportTypes;

		new Vue({
			el: $element,

			components: { BasketSummary },

			data()
			{
				return {
					summary,
					pathToOrder,
					exportTypes
				}
			},

			template: `<BasketSummary :summary="summary" :pathToOrder="pathToOrder" :exportTypes="exportTypes" />`,
		})
	}

	showLoading()
	{
		KTApp.block(`#${this.elementId}_block`);
	}

	hideLoading()
	{
		KTApp.unblock(`#${this.elementId}_block`);
	}

}
