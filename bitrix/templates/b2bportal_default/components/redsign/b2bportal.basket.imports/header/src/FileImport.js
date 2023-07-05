import FileImport from './FileImport.vue';

const { store } = B2BPortal;

export class BasketFileImport
{
	constructor(params)
	{
		this._params = params;
		this.el = params.el;
		this.modal = params.modal;
		this.signedParameters = params.signedParameters;

		this.init();
	}

	init()
	{
		const signedParameters = this.signedParameters;

		const startLoader = () => KTApp.block(this.modal);
		const endLoader = () => KTApp.unblock(this.modal);

		this.component = new Vue({
			el: this.el,
			components: { FileImport: FileImport },
			template: `<FileImport ref="fileImport" :signedParameters="signedParameters"/>`,
			store,

			data()
			{
				return { signedParameters }
			},

			mounted()
			{
				this.$refs.fileImport.$on('startLoader', startLoader);
				this.$refs.fileImport.$on('endLoader', endLoader);
			}
		});
	}
} 