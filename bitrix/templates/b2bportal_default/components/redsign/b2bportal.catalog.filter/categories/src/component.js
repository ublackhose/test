export class CSLTree 
{
	constructor(params)
	{
		({ 
			treeNode: this.treeNode,
			searchInputNode: this.searchInputNode
		} = params);

		if (!this.treeNode)
			throw new Error('CSLTree: tree not found');

		this.init();

		if (this.searchInputNode)
			this.initSearch();
	}

	init()
	{
		const onChangedHandle = BX.debounce((e, { selected }) => {
			this.onSelectedHandle(selected); 
		}, 1000);

		$(this.treeNode)
			.jstree({
				'plugins': ['search', 'checkbox', 'types'],
				'search': {
					'show_only_matches': true,
				},
				'types' : {
					'default' : {
						'icon': 'fa fa-folder kt-font-brand'
					}
				},
			}) 
			.on('ready.jstree', () => {
				setTimeout(() => {
					$(this.treeNode).on('changed.jstree', onChangedHandle);
				});
			});
	}

	initSearch()
	{
		$(this.searchInputNode).on('input', ({ target }) => {
			$(this.treeNode).jstree('search', target.value);
		});
	}

	onSelectedHandle(selected)
	{
		const filterCategories = selected
			.map(elementId => {
				const node = document.getElementById(elementId);
				return node ? node.getAttribute('data-section-id') : null;
			})
			.filter(sectionId => sectionId);

		this.sendRequest(filterCategories);
	}

	async sendRequest(filterCategories)
	{
		const uri = new BX.Uri(window.location.pathname + window.location.search);
		uri.setQueryParam('filter_categories', filterCategories);

		BX.onCustomEvent(
			`filter-arrFilter-on-submit`, 
			[
				{ 
					arrFilter_SUBSECTIONS: filterCategories 
				}
			]
		);
	}
}