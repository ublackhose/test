export class SaleOrderPaymentChange
{
	constructor($el, params)
	{
		this.$el = $el;

		this.ajaxPath = params.ajaxPath;
		this.accountNumber = params.accountNumber || {};
		this.paymentNumber = params.paymentNumber || {};
		this.onlyInnerFull = params.onlyInnerFull || "";
		this.templateName = params.templateName || "";
		this.pathToPayment = params.pathToPayment || "";
		this.refreshPrices = params.refreshPrices || "N";
		this.inner = params.inner || "";
		this.templateFolder = params.templateFolder;

		this.initEvents();
	}

	initEvents()
	{
		const pyamentNodes = this.$el.querySelectorAll('[data-entity="paysystem"]');
		if (pyamentNodes.length)
		{
			for (let i in pyamentNodes)
			{
				if (pyamentNodes.hasOwnProperty(i))
				{
					pyamentNodes[i].addEventListener('click', this.onSelectPaymentHandle.bind(this));
				}
			}
		}
	}

	async onSelectPaymentHandle(event)
	{
		event.preventDefault();

		const node = event.currentTarget || event.target.closest('[data-entity="paysystem"]');
		const paysystemId = node.getAttribute('data-paysystem-id');
		
		try
		{
			const result = await this.changePaysystem(paysystemId);
			
			const messages = result.messages;
			if (messages.length > 0) 
			{
				this.showMessages(messages);
			}

			if (result.isInnerPayment)
			{
				await this.innerPay(
					result.innerPaymentData, 
					result.isOnlyInnerFull
				);
			}

			BX.onCustomEvent('SaleOrderDetailPaysystemChanged');
		}
		catch(e)
		{
			console.warn(e);
		}
	}

	showMessages(messages = [])
	{
		messages.forEach(message => {
			
			if (message.type === 'error')
			{
				Swal.fire({
					type: 'error',
					text: message.text
				})
			}
			else
			{
				window.toastr[message.type](message.text);
			}
			
		});
	}

	async innerPay(data, isOnlyFull)
	{
		if (isOnlyFull)
		{
			const confirmInnerPay = await this.confirmInnerPay(data);
			if (confirmInnerPay)
			{
				await this.sendInnerPay(data.sum);
			}
		}
		else
		{
			const sum = await this.promptInnerPay(data);
			await this.sendInnerPay(sum);
		}
	}

	confirmInnerPay(data)
	{
		return (
			Swal.fire({
				title: BX.message('SOPC_TPL_SUM_TO_PAID') + ': ' + data.sumFormatted,
				type: 'warning',
				showCancelButton: true,
				confirmButtonText: BX.message('SOPC_TPL_PAY_BUTTON'),
				cancelButtonText: BX.message('SOPC_TPL_PAY_CANCEL')
			})
			.then((result) => result.value)
		);
	}

	promptInnerPay(data)
	{
		const sum = Number(data.sum);
		const budget = Number(data.budget);

		return (
			Swal.fire({
				title: BX.message('SOPC_TPL_SUM_TO_PAID') + ': ' + data.sumFormatted,
				input: 'number',
				inputAttributes: {
					min: 0,
					max: budget >= sum ? sum : budget
				},
				inputValue: budget >= sum ? sum : budget,
				showCancelButton: true,
				confirmButtonText: BX.message('SOPC_TPL_PAY_BUTTON'),
				cancelButtonText: BX.message('SOPC_TPL_PAY_CANCEL')
			})
			.then((result) => result.value)
		);
	}

	changePaysystem(paysystemId)
	{
		return new Promise((resolve, reject) => {
			BX.ajax({
				method: 'POST',
				dataType: 'json',
				url: this.ajaxPath,
				data: {
					sessid: BX.bitrix_sessid(),
					paySystemId: paysystemId,
					accountNumber: this.accountNumber,
					paymentNumber: this.paymentNumber,
					templateName: this.templateName,
					inner: this.inner,
					refreshPrices: this.refreshPrices,
					onlyInnerFull: this.onlyInnerFull,
					pathToPayment: this.pathToPayment
				},
				onsuccess: resolve,
				onfailure: reject
			});
		});
	}

	sendInnerPay(sum)
	{
		return new Promise((resolve, reject) => {
			BX.ajax({
				method: 'POST',
				dataType: 'json',
				url: this.ajaxPath,
				data: {
					sessid: BX.bitrix_sessid(),
						accountNumber: this.accountNumber,
						paymentNumber: this.paymentNumber,
						inner: "Y",
						onlyInnerFull: this.onlyInnerFull,
						paymentSum: sum
				},
				onsuccess: resolve,
				onfailure: reject
			});
		});
	}
}