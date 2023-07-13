export class KPEdit
{
	constructor(params)
	{
		this.signedParameters = params.signedParameters;
		this.editor = params.editor;
		this.nameInput = params.nameInput;
		this.linkInput = params.linkInput;
		this.copyToClipboardButton = params.copyToClipboardButton;
		this.deleteButton = params.deleteButton;
		this.shortLinkToggle = params.shortLinkToggle;

		this.download = params.download;
		this.shortlink = params.shortlink;
		this.isShowedShortlink = !!this.shortlink;

		this.editor.subscribe(RSKomPred.Editor.Events.CHANGED, this.saveData.bind(this));
		this.nameInput.addEventListener('change', this.saveData.bind(this));
		this.copyToClipboardButton.addEventListener('click', this.copyClipboard.bind(this));
		this.deleteButton.addEventListener('click', this.confirmDelete.bind(this));
		this.shortLinkToggle.addEventListener('click', this.toggleShortlink.bind(this));
	}

	async saveData()
	{
		const data = await this.editor.save();
		data.offer.name = this.nameInput.value;
		
		return new Promise((resolve, reject) => {
			BX.ajax.runAction('redsign:kompred.api.offer.save', { data: data })
				.then(resolve, reject);
		});
	}

	copyClipboard()
	{
		this.linkInput.focus();
		this.linkInput.select(); 
		document.execCommand('copy');
		
		if (window.toastr)
		{
			window.toastr.success(BX.message('RS_KP_KOE_T_COPY_TO_CLIPBOARD_SUCCESS'));
		}
	}

	confirmDelete(event)
	{
		event.preventDefault();

		Swal.fire({
			title: BX.message('RS_KP_KOE_T_DELETE_CONFIRM'),
			type: 'warning',
			showCancelButton: true,
			animation: false,
			confirmButtonText: BX.message('RS_KP_KOE_T_DELETE_CONFIRM_YES'),
			cancelButtonText:  BX.message('RS_KP_KOE_T_DELETE_CONFIRM_NO'),
		})
		.then((result) => {
			if (result.value)
				window.location = this.deleteButton.href;
		})
	}

	async toggleShortlink()
	{
		if (this.isShowedShortlink)
		{
			this.linkInput.value = this.download;
			this.isShowedShortlink = false;
		}
		else
		{
			if (!this.shortlink)
				await this.makeShortLink();

			this.linkInput.value = this.shortlink;
			this.isShowedShortlink = true;
		}
	}

	async makeShortLink()
	{
		this.shortLinkToggle.disabled = true;
		this.shortLinkToggle.classList.add('disabled');

		try
		{
			const result = await new Promise((resolve, reject) => {
				BX.ajax.runComponentAction(
					'redsign:kompred.offer.edit', 
					'makeShortLink', 
					{ 
						mode: 'class',
						data: { 
							signedParameters: this.signedParameters
						} 
					}
				).then(resolve, reject);
			});

			if (result.status === 'success' && result.data)
			{
				this.shortlink = `${window.location.protocol}//${window.location.host}${result.data}`;
			}
		}
		catch(e)
		{
			console.error(e);
		}
		finally
		{
			this.shortLinkToggle.disabled = false;
			this.shortLinkToggle.classList.remove('disabled');
		}
	}
}