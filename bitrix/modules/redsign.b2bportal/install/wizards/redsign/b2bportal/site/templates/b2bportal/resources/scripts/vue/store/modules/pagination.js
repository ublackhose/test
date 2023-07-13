import { types as listTypes } from './list';

export const types = {
	SET_PAGINATION: 'SET_PAGINATION',
	SET_PAGE: 'SET_PAGE',
	SET_PER_PAGE: 'SET_PER_PAGE'
};

const initialState = () => ({
	currentPage: 1,
	pageCount: 1,
	perPage: 5,
	perPageOptions: [5, 10, 15, 25],
	paramName: 'page',
	perPageParamName: 'perpage',
	pagePrefix: '',
	sef: false,
	sefPath: ''
});

const actions = {
	setPage({ state, commit, dispatch }, pageNumber)
	{
		commit(types.SET_PAGE, pageNumber);

		if (state.sef)
		{
			const uri = new BX.Uri(state.sefPath);
			console.log(uri);
			uri.setPath(`${uri.getPath()}${state.paramName}/${state.pagePrefix}${pageNumber}/`);

			return dispatch('fetch', { url: uri.toString() })
		}
		else
		{
			const params = {};
			params[state.paramName] =  state.pagePrefix + pageNumber;

			return dispatch('fetch', { params });
		}
	},
	setPerPage({ state, commit, dispatch }, perPage)
	{
		commit(types.SET_PER_PAGE, perPage);

		const params = {
			[state.perPageParamName]: perPage
		};

		return dispatch('fetch', { params })
			.then(res => {
				commit(
					listTypes.SAVE_PARAMS,
					{
						[state.perPageParamName]: state.perPage
					}
				);
				return res;
			});
	}
};

const mutations = {
	[types.SET_PAGINATION]: (state, pagination) => Object.assign(state, pagination),
	[types.SET_PAGE]: (state, pageNumber) => state.currentPage = pageNumber,
	[types.SET_PER_PAGE]: (state, perPage) => state.perPage = perPage
};

export function createStore(state = {})
{
	return {
		state: Object.assign(initialState(), state),
		actions,
		mutations
	};
}

export default {
	createStore,
	types
}