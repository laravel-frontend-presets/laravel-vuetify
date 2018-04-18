export default {
  logged: state => state.logged,
  token: state => state.token,
  user: state => state.user,
  roles: state => state.user ? state.user.roles : []
}
