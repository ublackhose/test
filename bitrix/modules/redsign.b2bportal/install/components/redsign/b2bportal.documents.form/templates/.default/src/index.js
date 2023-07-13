import './component';
import './style.css';

export class DocumentsEditForm 
{
	constructor(el, params)
	{
		this.el = el;
		this.params = params;

		this.useGrid();
		this.attachTemplate();

		console.log('init');
	}

	useGrid()
	{
		const globalBX = (window.parent || window).BX;
		const grid = globalBX.Main.gridManager ? globalBX.Main.gridManager.getInstanceById('document_list') : false;
		if (grid)
			this.onGridReady(grid);
		else
			BX.addCustomEvent('Grid::ready', this.onGridReady.bind(this));
	}

	onGridReady(grid)
	{
		if (grid.getContainerId() !== 'document_list') 
			return;

		this.grid = grid;

		BX.addCustomEvent('SidePanel.Slider:onReload', (e) => {
			this.grid.reloadTable('POST', {})
		});
	}

	attachTemplate()
	{
		const { form, siteId, orderId, userId, filledValues, propsValues } = this.params;

		this.template = BX.Vue.create({
			el: this.el,
			data: { form, siteId, orderId, userId, filledValues, propsValues },
			template: `
				<bx-b2bportal-documents-edit-form 
					:form="form"
					:siteId="siteId"
					:orderId="orderId"
					:userId="userId" 
					:filledValues="filledValues"
					:propsValues="propsValues"
				/>
			`
		})
	}
}