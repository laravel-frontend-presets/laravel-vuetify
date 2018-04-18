import gravatar from 'gravatar'

export default {
  methods: {
    gravatarURL (email) {
      return gravatar.url(email)
    }
  }
}
