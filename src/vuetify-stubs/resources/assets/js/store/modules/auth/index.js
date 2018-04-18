import getters from './getters'
import actions from './actions'
import mutations from './mutations'

const state = {
  token: null,
  user: null,
  logged: false
}

export default {
  state,
  getters,
  actions,
  mutations
}
