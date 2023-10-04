

const getters = {

	getSkuPropsByIblockId(state)
	{
		return iblockId => state.skuProps[iblockId] || [];
	},

	getEditAreas(state)
	{
		return state.editAreas;
	},

	isShowPreview(state)
	{
		return state.settings.preview;
	},

	getToolbarOptions(state)
	{
		return state.toolbar;
	},

	getPrices(state)
	{
		return state.prices;
	}
};

const mutations = {

	SET_SHOW_PREVIEW(state, status)
	{
		state.settings.preview = status;
	},

	ADD_SKU_PROPS(state, { iblockId, props })
	{
		Vue.set(state.skuProps, iblockId, props);
	},


	ADD_EDIT_AREA(state, { id, actions })
	{
		Vue.set(state.editAreas, id, actions);
	},

};

const actions = {
	
	togglePreview({ state, commit })
	{
		commit('SET_SHOW_PREVIEW', !state.settings.preview);
		localStorage.setItem(state.prefix + '_preview_switcher', state.settings.preview);
	},

	setSkuProps({ commit }, payload)
	{
		for (const iblockId in payload)
		{
			commit('ADD_SKU_PROPS', {
				iblockId,
				props: payload[iblockId]
			});
		}
	},

	setEditAreas({ commit }, payload)
	{
		for (const id in payload)
		{
			commit(`ADD_EDIT_AREA`, {
				id, 
				actions: payload[id]
			});
		}
	},

	initial({ commit, state })
	{
		if (state.settings.preview)
		{
			if (state.toolbar.previewSwitcher)
			{
				if (localStorage.getItem(state.prefix + '_preview_switcher'))
				{ 
					commit('SET_SHOW_PREVIEW', localStorage.getItem(state.prefix + '_preview_switcher') === 'true');
				}
				else
				{
					localStorage.setItem(state.prefix + '_preview_switcher', state.settings.preview);
				}
			}
		}
	}

}; 


export const INITIAL_STATE = {
	settings: {
		preview: false,
	},
	prefix: '',
	toolbar: {},
	skuProps: {},
	editAreas: {},
	prices: {}
};

export function createStore (initialState)
{
	return {
		namespaced: true,

		state: initialState || INITIAL_STATE,
		getters,
		mutations,
		actions,
	};
}