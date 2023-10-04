export class Payment
{
	constructor(el, params)
	{
		this.$el = el;

		this.data = params.paymentData;

		this.ajaxPath = params.ajaxPath || '';
		this.templateName = params.templateName || '.default';

		this.initEvents();
	}

	initEvents()
	{
		const changeButton = this.$el.querySelector('[data-entity="change-payment"]');
		if (changeButton)
		{
			changeButton.addEventListener('click', this.onChangePaymentHandle.bind(this), {once: true});
		}
	}

	onChangePaymentHandle(event)
	{
		event.preventDefault();

		BX.ajax({
				method: 'POST',
				dataType: 'html',
				url: this.ajaxPath,
				data:
				{
					sessid: BX.bitrix_sessid(),
					orderData: this.data,
					templateName : this.templateName
				},
				onsuccess: html => {
					const dropdown = this.$el.querySelector('[data-entity="payment-list"]');
					dropdown.innerHTML = html;
				},
		});
	}
}