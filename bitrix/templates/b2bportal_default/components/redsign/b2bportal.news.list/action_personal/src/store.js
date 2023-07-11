export default {

	namespaced: true,

	state: {
		editAreas: {},
	},

	getters: {
		editAreas(state)
		{
			return state.editAreas;
		},
	},

	mutations: {
		ADD_EDIT_AREA(state, data)
		{
			Vue.set(state.editAreas, data.id, data.actions);
		},
	},

}
