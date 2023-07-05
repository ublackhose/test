import CodesImport from './CodesImport.vue';

const { store } = B2BPortal;

export class BasketCodesImport
{
	constructor(params)
	{
		this._params = params;
		this.el = params.el;
		this.signedParameters = params.signedParameters;

		this.init();
	}

	init()
	{
		const signedParameters = this.signedParameters;

		this.component = new Vue({
			el: this.el,
			components: { CodesImport },
			template: `<CodesImport :signedParameters="signedParameters" />`,
			store,

			data()
			{
				return { signedParameters }
			}
		});
	}
}