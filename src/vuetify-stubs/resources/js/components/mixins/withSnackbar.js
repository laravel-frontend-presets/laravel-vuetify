import * as mutations from '../../store/mutation-types'
import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters([
      'snackbarTimeout'
    ])
  },
  methods: {
    showMessage (message) {
      this.showSnackBar(message, 'success')
    },
    showError (error) {
      this.showSnackBar(error, 'error')
    },
    cleanState () {
      setTimeout(() => {
        this.$store.commit(mutations.SET_SNACKBAR_SHOW, false)
      }, this.snackbarTimeout)
    },
    showSnackBar (message, color) {
      this.$store.commit(mutations.SET_SNACKBAR_SHOW, true)
      this.$store.commit(mutations.SET_SNACKBAR_COLOR, color || 'error')
      if (typeof message === 'string') {
        this.$store.commit(mutations.SET_SNACKBAR_TEXT, message)
        this.cleanState()
        return
      }
      this.$store.commit(mutations.SET_SNACKBAR_TEXT, message.message)
      if (message.response) this.$store.commit(mutations.SET_SNACKBAR_SUBTEXT, message.response.data.message)
      this.cleanState()
    }
  }
}
