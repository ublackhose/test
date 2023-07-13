import { createStore as createPagination, types as paginationTypes } from "./pagination";

export const types = {
	START_FETCHING: 'START_FETCHING',
	END_FETCHING: 'END_FETCHING',
	ADD_ITEMS: 'ADD_ITEMS',
	SET_ITEMS: 'SET_ITEMS',
	SAVE_PARAMS: 'SAVE_PARAMS',
	UNSAVE_PARAMS: 'UNSAVE_PARAMS'
};

async function sendRequest(url, comp_id, data)
{
	const params = {
		url,
		method: 'POST',
		dataType: 'json',
		data: {
			...data,
			comp_id
		},
	};

	return new Promise((resolve, reject) => {
		BX.ajax.promise(params).then(resolve).catch(reject);
	});
}

const initialState = () => ({
	id: 'item_list',
	fetching: false,
	saveParams: {},
	iblock: {
		messages: {
			edit_link: '',
			delete_link: ''
		}
	},
	items: [],
});

const actions = {
	async fetch({ state, commit }, payload = {})
	{
		const params = {...state.saveParams, ...(payload.params || {})};
		const data = payload.data || {};

		let url = payload.url || window.location.pathname + window.location.search;
		if (Object.keys(params).length)
		{
			console.log(params);
			url = BX.Uri.addParam(url, params);
			console.log(url);
		}

		commit(types.START_FETCHING);

		try
		{
			const res = await sendRequest(url, state.id, { data });
			if (res.status === 'success')
			{
				if (res.data.items)
				{
					commit(types.SET_ITEMS, res.data.items);
				}

				if (res.data.pagination)
				{
					commit(paginationTypes.SET_PAGINATION, res.data.pagination);
				}

				if (res.data.url)
				{
					BX.ajax.history.put(null, res.data.url);
				}
			}

			return res;
		}
		catch(e)
		{
			console.error(e);
		}
		finally
		{
			commit(types.END_FETCHING)
		}
	}
};

const mutations = {
	[types.START_FETCHING]: (state) => state.fetching = true,
	[types.END_FETCHING]: (state) => state.fetching = false,
	[types.SET_ITEMS]: (state, items) => Vue.set(state, 'items', items),
	[types.ADD_ITEMS]: (state, items) => Object.assign(state.items, items),
	[types.SAVE_PARAMS]: (state, params) => Object.keys(params).forEach((key) => Vue.set(state.saveParams, key, params[key])),
	[types.UNSAVE_PARAMS]: (state, keys) => keys.forEach((val, key) => Vue.delete(state.saveParams, key))
};

export function createStore(state) {
	return {
		namespaced: true,
		modules: {
			pagination: createPagination(state.pagination)
		},
		state: () => Object.assign(initialState(), state),
		actions,
		mutations
	};
};

export default {
	createStore,
	types
}