//state
const getDefaultState = () => {
  return {
		loaded: false,
		//page
		default_dashboard: null,
		pages: [],		
  }
}
const state = getDefaultState()

//mutations
const mutations = {
	setLoaded(state, loaded) {
		state.loaded = loaded;
	},
	setNewPage(state, page) {
		state.pages.push(page)
	},
	replacePage(state, page, index) {
		state.pages[index] = page
	},
	removePage(state, name) {
		var i
		for (i = 0; i < state.pages.length; i++) {
			if (state.pages[i].name == name) {
				state.pages.splice(i, 1)
				break
			}
		}
	},	
	resetState(state) {
		Object.assign(state, getDefaultState());
	},
}

//getters
const getters = {
	Page: state => name => {
		let page = state.pages.find(halaman => halaman.name == name);
		return page;
	},
	AtributeValueOfPage: state => (name, key) => {
		let page = state.pages.find(halaman => halaman.name == name);
		return page[key];
	},	
}

//actions
const actions = { 
	addToPages({ commit, state }, page) {
		let found = state.pages.find(halaman => halaman.name == page.name)
		if (!found) {
			commit('setNewPage', page)
		}
	},
	updatePage({ commit, state },page) {
		var i
		for (i = 0; i < state.pages.length; i++) {
			if (state.pages[i].name == page.name) {
				break
			}
		}
		commit('replacePage', page, i)
	},
	deletePage({ commit },name) {
		commit('removePage', name)
	},	
	reinit({ commit }) {
		commit("resetState");
	},
}
export default {
	namespaced: true,
	state,
	mutations,
	getters,
	actions,
}