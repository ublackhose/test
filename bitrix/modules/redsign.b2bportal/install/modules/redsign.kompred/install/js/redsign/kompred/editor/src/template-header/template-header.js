import './template-header.css';

class TemplateHeader
{
	static get toolbox()
	{
		return {
			title: BX.message('RS_KP_EDIT_BLOCK_TEMPLATE_HEADER'),
			icon: `<svg style="width: 18px;" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m21 0h-18c-1.654 0-3 1.346-3 3v18c0 1.654 1.346 3 3 3h18c1.654 0 3-1.346 3-3v-18c0-1.654-1.346-3-3-3zm1 21c0 .552-.449 1-1 1h-18c-.551 0-1-.448-1-1v-18c0-.552.449-1 1-1h18c.551 0 1 .448 1 1z"/><path d="m18.25 4h-12.5c-.965 0-1.75.785-1.75 1.75v3.5c0 .965.785 1.75 1.75 1.75h12.5c.965 0 1.75-.785 1.75-1.75v-3.5c0-.965-.785-1.75-1.75-1.75z"/></g></svg>`
		};
	}

	constructor({ data, config })
	{
		this.data = data;
		this.config = config;
	}

	render()
	{
		const wrapper = document.createElement('table');
		wrapper.classList.add('rskp-e-header');

		const contacts = document.createElement('div');
		contacts.setAttribute('data-editor-entity', 'contacts');
		contacts.contentEditable = true;
		contacts.innerHTML = this.data.contacts || '';

		const logo = document.createElement('img');
		logo.setAttribute('data-editor-entity', 'logo');
		logo.src = this.data.logo || this.config.defaultLogo || '';

		wrapper.innerHTML = `
			<tr>
				<td class="rskp-e-header__logo">
					${logo.outerHTML}
				</td>
				<td class="rskp-e-header__contacts">
					${contacts.outerHTML}
				</td>
			</tr>
		`;
		
		return wrapper;
	}

	save(blockContent)
	{
		const contactsBlock = blockContent.querySelector('[data-editor-entity="contacts"]');
		const logoBlock = blockContent.querySelector('[data-editor-entity="logo"]');

		return {
			contacts: contactsBlock.innerHTML,
			logo: logoBlock.getAttribute('src')
		};
	}
}

export default TemplateHeader;