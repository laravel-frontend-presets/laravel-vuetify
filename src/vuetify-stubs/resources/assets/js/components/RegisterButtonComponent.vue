<template>
    <v-dialog
            fullscreen
            v-if="show"
            v-model="showRegister"
            persistent>
        <v-btn slot="activator">Register</v-btn>
        <v-card>
            <v-card-title>
                <span class="headline">User registration</span>
            </v-card-title>
            <v-card-text>
                <v-form ref="registrationForm" v-model="valid">
                    <v-text-field
                            label="User name"
                            v-model="name"
                            :rules="nameRules"
                            required
                    ></v-text-field>
                    <v-text-field
                            label="Email"
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
                            :error="errors['email']"
                            :error-messages="errors['email']"
                            required
                            min="6"
                            type="password"
                            required
                    ></v-text-field>
                    <v-text-field
                            name="password"
                            label="Password confirmation"
                            v-model="passwordConfirmation"
                            :rules="passwordRules"
                            hint="At least 6 characters"
                            min="6"
                            type="password"
                            required
                            :error="errors['password']"
                            :error-messages="errors['password']"
                    ></v-text-field>
                </v-form>
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
                    <span class="ml-1">Register with Facebook</span>
                </v-btn>
                <a href="/login" color="blue darken-2">
                    I already have an user
                </a>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click.native="showRegister = false">Close</v-btn>
                <v-btn :loading="registerLoading" color="blue darken-1" class="white--text" @click.native="register">Register</v-btn>
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
        name: '',
        nameRules: [
          (v) => !!v || 'User name is mandatory'
        ],
        email: '',
        emailRules: [
          (v) => !!v || 'Mail is mandatory',
          (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Email have to be valid'
        ],
        password: '',
        passwordRules: [
          (v) => !!v || 'Password is mandatory',
          (v) => v.length >= 6 || 'Password at least have to be 6 characters'
        ],
        passwordConfirmation: '',
        valid: false,
        registerLoading: false
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
      showRegister: {
        get () {
          if (this.internalAction && this.internalAction === 'register') return true
          return false
        },
        set (value) {
          if (value) this.internalAction = 'register'
          else this.internalAction = null
        }
      },
    },
    methods: {
      register () {
        if (this.$refs.registrationForm.validate()) {
          this.registerLoading = true
          const user = {
            'name': this.name,
            'email': this.email,
            'password': this.password,
            'password_confirmation': this.passwordConfirmation,
          }
          this.$store.dispatch(actions.REGISTER, user).then(response => {
            this.registerLoading = false
            this.showRegister = false
            window.location = '/home'
          }).catch(error => {
            if (error.response && error.response.status === 422) {
              this.showError({
                message: 'Invalid data'
              })
            } else {
              this.showError(error)
            }
            this.errors = error.response.data.errors
          }).then(() => {
            this.registerLoading = false
          })
        }
      },
    }
  }
</script>
