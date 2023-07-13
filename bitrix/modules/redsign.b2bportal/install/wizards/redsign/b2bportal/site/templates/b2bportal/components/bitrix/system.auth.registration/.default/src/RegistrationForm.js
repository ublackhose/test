import VueCreateCompanyForm from './VueCreateCompanyForm.vue';

var valGetParentContainer = function(element) {
	var element = $(element);

	if ($(element).closest('.form-group-sub').length > 0) {
		return $(element).closest('.form-group-sub')
	} else if ($(element).closest('.bootstrap-select').length > 0) {
		return $(element).closest('.bootstrap-select')
	} else {
		return $(element).closest('.form-group');
	}
}

const createValidator = $form => $form.validate({
	ignore: ":hidden",
	errorPlacement: function ( error, element ) {
		var element = $(element);

		var element = $(element);

		var group = valGetParentContainer(element);
		var help = group.find('.form-text');

		if (group.find('.valid-feedback, .invalid-feedback').length !== 0) 
		{
			return;
		}

		element.addClass('is-invalid');
		error.addClass('invalid-feedback');

		if (help.length > 0) 
		{
			help.before(error);
		} 
		else 
		{
			if (element.closest('.bootstrap-select').length > 0) 
			{ 
				element.closest('.bootstrap-select').find('.bs-placeholder').after(error);
			} 
			else if (element.closest('.input-group').length > 0 || element.closest('.kt-input-icon').length > 0) 
			{
				element.parent().after(error);
			} 
			else 
			{ 
				if (element.is(':checkbox')) 
				{
					element.closest('.kt-checkbox').find('> span').after(error);
				}
				else 
				{
					element.after(error);
				}                
			}            
		}

	},

	rules: {
		USER_CONFIRM_PASSWORD: {
			equalTo: "input[name=\"USER_PASSWORD\"]"
		}
	}
});

export class RegistrationForm
{
	constructor(el, data)
	{
		this.el = el;
		this.data = data;
		this.form = this.el.querySelector('form');

		this.wizard = new KTWizard(this.el);
		this.validator = createValidator($(this.form));

		this.wizard.on('beforeNext', (wizardObj) => {
			if (!this.validator.form()) wizardObj.stop();
		});

		this.attachCreateCompanyForm();
	}

	attachCreateCompanyForm()
	{
		const el = this.el.querySelector('[data-form="create_company"]');
		const components = { VueCreateCompanyForm };
		
		const {personTypes, orderProps, orderPropsGroups, values} = this.data;

		this.createCompanyForm = new Vue({
			el,
			components,

			data()
			{
				return {
					personTypes,
					orderProps,
					orderPropsGroups,
					values
				};
			},

			template: `
				<VueCreateCompanyForm 
					:personTypes="personTypes"
					:orderProps="orderProps"
					:orderPropsGroups="orderPropsGroups"
				/>
			`
		});
	}
}