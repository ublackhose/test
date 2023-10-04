export class SalePersonalProfileSelect
{

	constructor()
	{
		this.initListeners()
	}

	initListeners()
	{
		let elements = document.querySelectorAll('.js-spps-select');

		if (elements)
		{
			elements.forEach((link) => {
				link.addEventListener('click', (e) => {
					e.preventDefault()
					this.setCurrentProfile(link.getAttribute('data-id'))
				})
			})
		}
	}

	setCurrentProfileAction(data)
	{
		return new Promise((resolve, reject) => {
			BX.ajax.runComponentAction(
				'redsign:b2bportal.sale.personal.profile.select',
				'setCurrentProfile',
				{ 
					mode: 'class',
					data: data,
				}
			).then(resolve, reject)
		})
	}

	async setCurrentProfile(id = 0)
	{
		try {
			KTApp.blockPage()

			let data = {
				id: id,
			}

			let result = await this.setCurrentProfileAction(data)

			if (result.data.result == true)
			{
				BX.reload()
			}
			else
			{
				result.data.ERRORS.forEach((errorMessage) => this.showError(errorMessage))
			}
		}
		catch (e)
		{
			if (e.errors)
			{
				e.errors.forEach((error) => this.showError(error.message))
			}
			else
			{
				this.showError('Unknown error')
			}

			KTApp.unblockPage()
		}
	}

	showError(message)
	{
		window.toastr.error(
			message
		); 
	}

}
