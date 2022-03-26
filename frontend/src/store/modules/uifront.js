//state
const getDefaultState = () => {
	return {
		loaded: false,	
	}
}
const state = getDefaultState()
const mutations = {
	resetState(state) {
    Object.assign(state, getDefaultState())
  },
}
const getters = {}
const actions = {
  reinit({ commit }) {
    commit('resetState')
  },
}
export default {
	namespaced: true,
	state,
	mutations,
	getters,
	actions,
}