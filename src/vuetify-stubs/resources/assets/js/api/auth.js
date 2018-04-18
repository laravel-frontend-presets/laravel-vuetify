import axios from 'axios'

export default {
  login (credentials) {
    return axios.post('/login', credentials)
  },
  logout () {
    return axios.post('/logout')
  },
  register (user) {
    return axios.post('/register', {
      'name': user.name,
      'email': user.email,
      'password': user.password,
      'password_confirmation': user.password_confirmation,
    })
  },
  remember (email) {
    return axios.post('/password/email', { 'email': email })
  },
  reset (user) {
    return axios.post('/password/reset', {
      'email': user.email,
      'password': user.password,
      'password_confirmation': user.password_confirmation,
      'token': user.token
    })
  }
}
