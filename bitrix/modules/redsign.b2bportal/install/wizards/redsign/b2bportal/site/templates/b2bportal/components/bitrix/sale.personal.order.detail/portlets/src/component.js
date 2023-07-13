export class Blocks
{
	constructor($el, columns = [])
	{
		this.$el = $el;
		this.columns = columns;
		
		this.init();
	}

	init()
	{
		if (window.dragula)
		{
			this.drake = dragula(
				this.columns,
				{
					moves(el, container, handle) 
					{
						return (
							handle.classList.contains('kt-portlet__head') || 
							( handle.closest('.kt-portlet__head') && (!handle.classList.contains('btn') && !handle.closest('.btn')))
						);
					}
				}
			);

			this.drake.on('dragend', this.saveSorting.bind(this));
		}

		BX.addCustomEvent('SaleOrderDetailPaysystemChanged', () => this.reload('payment'));

		$(this.$el).find('.kt-portlet > .collapse').on('hidden.bs.collapse shown.bs.collapse', this.saveCollapsed.bind(this));
	}

	async reload(blockName)
	{
		const blockNode = this.$el.querySelector('[data-block="' + blockName + '"]');
		
		if (blockNode)
		{
			const url = window.location.href;
			KTApp.block(blockNode);
			
			try
			{
				const result = await this.sendRequest(url, {'reload_block': blockName});
				const processed = BX.processHTML(result);
				
				const contentNode = blockNode.querySelector('.kt-portlet__body');
				if (contentNode)
				{
					contentNode.innerHTML =  processed.HTML;
					BX.ajax.processScripts(processed.SCRIPT);
				}
			}
			catch(e)
			{
				console.warn(e);
			}
			finally
			{
				KTApp.unblock(blockNode);
			}
		}
	}

	sendRequest(url, data = {}, params = {})
	{
		return new Promise((resolve, reject) => {
			BX.ajax({
				method: params.method || 'POST',
				dataType: params.dataType || 'html',
				url: url,
				data: data,
				processData: false,
				onsuccess: resolve,
				onfailure: reject
			});
		});
	}

	getPositions()
	{
		return this.columns.map(column => {
			return Object.values(column.children).map(el => el.getAttribute('data-block'));
		});
	}

	getCollapsed()
	{
		return (
			Object
				.values(this.$el.querySelectorAll('.kt-portlet > .collapse'))
				.filter(el => !el.classList.contains('show'))
				.map(el => el.closest('[data-block]').getAttribute('data-block'))
		);
	}

	async saveSorting()
	{
		const sorting = this.getPositions();

		try
		{
			await BX.ajax.runAction(
				'redsign:b2bportal.api.userSettings.set', 
				{ data: { key: 'sod_sorted_blocks', value: sorting } }
			);
		}
		catch(e)
		{
			console.warn(e);
		}
	}

	async saveCollapsed()
	{
		const collapsed = this.getCollapsed();

		try
		{
			await BX.ajax.runAction(
				'redsign:b2bportal.api.userSettings.set', 
				{ data: { key: 'sod_collapsed_blocks', value: collapsed } }
			);
		}
		catch(e)
		{
			console.warn(e);
		}
	}
}