export const getSuggestValue = (suggestion, fieldType) => {
	switch (fieldType)
	{
		case 'INN':
			return (suggestion.data || {}).inn || '';
		case 'OGRN':
			return (suggestion.data || {}).ogrn || '';
		case 'ADDRESS':
			return ((suggestion.data || {}).address || {}).value || '';
		case 'KPP':
			return ((suggestion.data || {}).kpp || '');
		default:
			return suggestion.value;
	}
};