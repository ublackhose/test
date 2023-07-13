import VueKPTable from './vue-kp-table.vue';

const { store } = B2BPortal;
const { createStore, types } = B2BPortal.Vue.Store.List;

export class KPList 
{
	constructor(el, params = {})
	{
		this.el = el;
		this.params = params;

		this.initializeStore();
		this.attachTemplate();
	}

	initializeStore()
	{
		const state = {
			id: this.params.id,
			items: this.params.rows,
			pagination: this.params.pagination
		};
		
		store.registerModule(this.params.id, createStore(state));
	}


	async delete(id)
	{
		try
		{
			const delResult = await new Promise((resolve, reject) => {
				BX.ajax.runAction('redsign:kompred.api.offer.delete', { data: { id } })
					.then(resolve, reject)
			});

			if (delResult.data)
			{
				await store.dispatch(`${this.params.id}/fetch`);
			}
		}
		catch(e)
		{
			console.error(e);
		}
	}

	fetch()
	{
		const url = window.location.pathname + window.location.search;
		
		const requestParams = {
			url,
			method: 'POST',
			dataType: 'json',
			data: { 
				...data,
				comp_id
			},
		};

		return new Promise((resolve, reject) => {
			BX.ajax.promise(requestParams).then(resolve).catch(reject);
		});
	}

	attachTemplate()
	{
		const { columns } = this.params;

		this.$template = new (Vue.extend(VueKPTable))({
			propsData: { namespace: this.params.id, columns}
		});

		const templateElement = document.createElement('div');
		this.el.appendChild(templateElement);
		this.$template.$mount(templateElement);

		this.$template.$on('delete', this.delete.bind(this));
	}
}