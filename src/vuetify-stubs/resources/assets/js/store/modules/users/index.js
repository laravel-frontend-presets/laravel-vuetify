import getters from './getters'
import actions from './actions'
import mutations from './mutations'

const state = {
  selected_user: {},
  users: []
}

export default {
  state,
  getters,
  actions,
  mutations
}
