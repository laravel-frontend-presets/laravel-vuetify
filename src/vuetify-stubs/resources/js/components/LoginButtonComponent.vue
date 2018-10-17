<template>
    <v-dialog
            v-show="show"
            v-model="showLogin"
            persistent max-width="500px"
            :fullscreen="$vuetify.breakpoint.xsOnly">
        <v-btn color="primary" dark slot="activator">Login</v-btn>

        <v-card>
            <v-card-title>
                <span class="headline">Login</span>
            </v-card-title>
            <v-card-text>
                <v-form ref="loginForm" v-model="valid">
                    <v-text-field
                            name="email"
                            label="E-mail"
                            v-model="email"
                            :rules="emailRules"
                            :error="errors['email']"
                            :error-messages="errors['email']"
                            required
                    ></v-text-field>
                    <v-text-field
                            name="password"
                            label="Password"
                            v-model="password"
                            :rules="passwordRules"
                            hint="At least 6 characters"
                            min="6"
                            type="password"
                            required
                    ></v-text-field>
                </v-form>
                <v-container grid-list-md text-xs-center>
                    <v-layout row wrap>
                        <v-flex xs12>
                            <v-btn href="/auth/facebook" style="background-color: #3b5998;" class="white--text">
                                <svg class="facebook" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 width="266.893px" height="266.895px" viewBox="0 0 266.893 266.895" enable-background="new 0 0 266.893 266.895"
                                 xml:space="preserve">
                                    <path id="Blue_1_" fill="#3C5A99" d="M248.082,262.307c7.854,0,14.223-6.369,14.223-14.225V18.812
                                        c0-7.857-6.368-14.224-14.223-14.224H18.812c-7.857,0-14.224,6.367-14.224,14.224v229.27c0,7.855,6.366,14.225,14.224,14.225
                                        H248.082z"/>
                                    <path id="f" fill="#FFFFFF" d="M182.409,262.307v-99.803h33.499l5.016-38.895h-38.515V98.777c0-11.261,3.127-18.935,19.275-18.935
                                        l20.596-0.009V45.045c-3.562-0.474-15.788-1.533-30.012-1.533c-29.695,0-50.025,18.126-50.025,51.413v28.684h-33.585v38.895h33.585
                                        v99.803H182.409z"/>
                                </svg>
                                <span class="ml-1">Login with Facebook</span>
                            </v-btn>
                        </v-flex>
                        <v-flex xs12>
                            <a href="/password/reset" color="blue darken-2">
                                Remember password</a>
                        </v-flex>
                        <v-flex xs12>
                            <a href="/register" color="blue darken-2">
                                Register
                            </a>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-2" flat @click.native="showLogin = false">Close</v-btn>
                <v-btn color="blue darken-2" class="white--text" @click.native="login" :loading="loginLoading">Login</v-btn>
                <v-spacer></v-spacer>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<style scoped>
    .facebook {
        width: 20px;
    }
</style>

<script>
  import * as actions from '../store/action-types'
  import withSnackbar from './mixins/withSnackbar'
  export default {
    mixins: [withSnackbar],
    data () {
      return {
        errors: [],
        internalAction: this.action,
        email: '',
        emailRules: [
          (v) => !!v || 'Email is mandatory',
          (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Email have to be a valid email'
        ],
        password: '',
        passwordRules: [
          (v) => !!v || 'Password is mandatory',
          (v) => v.length >= 6 || 'Password have to be at least 6 characters long'
        ],
        valid: false,
        loginLoading: false
      }
    },
    props: {
      action: {
        type: String,
        default: null
      },
      show: {
        type: Boolean,
        default: true
      }
    },
    computed: {
      showLogin: {
        get () {
          if (this.internalAction && this.internalAction === 'login') return true
          return false
        },
        set (value) {
          if (value) this.internalAction = 'login'
          else this.internalAction = null
        }
      }
    },
    methods: {
      login () {
        if (this.$refs.loginForm.validate()) {
          this.loginLoading = true
          const credentials = {
            'email': this.email,
            'password': this.password
          }
          this.$store.dispatch(actions.LOGIN, credentials).then(response => {
            this.loginLoading = false
            this.showLogin = false
            window.location = '/home'
          }).catch(error => {
            console.log('HEY:')
            console.log(error.response.data)
            if (error.response && error.response.status === 422) {
              this.showError({
                message: 'Invalid data',
              })
            } else {
              this.showError(error)
            }
            this.errors = error.response.data.errors
          }).then(() => {
            this.loginLoading = false
          })
        }
      },
    }
  }
</script>
