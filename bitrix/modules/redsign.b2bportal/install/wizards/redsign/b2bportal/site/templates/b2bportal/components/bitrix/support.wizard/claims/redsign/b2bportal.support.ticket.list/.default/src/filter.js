export function clearFilter(form)
{
	for(var i=0, n=form.elements.length; i<n; i++)
	{
		var el = form.elements[i];
		switch(el.type.toLowerCase())
		{
			case 'text':
			case 'textarea':
				el.value = '';
				break;
			case 'select-one':
				el.selectedIndex = 0;
				break;
			case 'select-multiple':
				for(var j=0, l=el.options.length; j<l; j++)
					el.options[j].selected = false;
				break;
			case 'checkbox':
				el.checked = false;
				break;
			default:
				break;
		}
		if(el.onchange)
			el.onchange();
	}

	BX.onCustomEvent(form, "onGridClearFilter", []);

	// form.clear_filter.value = "Y";

	BX.submit(form);
}