import Table from './table';

export default class TableFilter extends Table
{

	constructor(data, params)
	{
		super(data, params)

		this.attachEvents()
	}

	attachEvents()
	{
		this.attachEventFilter()
	}

	attachEventFilter()
	{
		BX.addCustomEvent(
			`filter-${this.params.filter.filterName}-on-submit`,
			(data, url) => {
				let key

				for (key in data)
				{
					this.requestData[key] = ''

					if (data[key] && data[key] != '')
					{
						this.requestData[key] = data[key]
					}
				}

				this.makeRequest(url)
			}
		)

		BX.addCustomEvent(
			`filter-${this.params.filter.filterName}-on-reset`,
			(data, url) => {
				let key

				for (key in data)
				{
					this.requestData[key] = ''
				}

				this.makeRequest(url)
			}
		)
	}

}

window.TableFilter = TableFilter;
