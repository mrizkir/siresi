<template>
  <FrontLayout>
    <v-container class="white pa-0" fluid>
      <v-row no-gutters align="center" justify="center">
        <v-col sm="12" md="4">
          <v-card class="pa-0" elevation="0" tile>
            <v-card height="480px" elevation="0">
              <template v-slot:prepend>
                <h1 class="text-center display-1 font-weight-black green--text">
                  SIRESI
                </h1>
              </template>
              <v-form
                ref="frmlogin"
                @keyup.native.enter="doLogin"
                lazy-validation
              >
                <h1
                  class="text-center display-1 font-weight-black pa-3"
                  style="color: #1a237e"
                >
                  SIRESI
                </h1>
                <v-card-text>
                  <v-text-field
                    v-model="formlogin.username"
                    label="Username"
                    :rules="rule_username"
                    outlined
                    dense
                  />
                  <v-text-field
                    v-model="formlogin.password"
                    label="Password"
                    type="password"
                    :rules="rule_password"
                    outlined
                    dense
                  />
                  <v-alert
                    outlined
                    dense
                    type="error"
                    :value="form_error"
                    icon="mdi-close-octagon-outline"
                  >
                    Username atau Password tidak dikenal.
                  </v-alert>
                </v-card-text>
                <v-card-actions class="justify-center">
                  <v-btn
                    height="50px"
                    color="#1A237E"
                    class="white--text"
                    @click="doLogin"
                    :disabled="btnLoading"
                    block
                  >
                    Sign In
                  </v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </FrontLayout>
</template>
<script>
  import FrontLayout from '@/views/layouts/FrontLayout'
  export default {
    name: 'Login',
    created() {
      if (this.$store.getters['auth/Authenticated']) {
        this.$router.push(
          '/dashboard/' + this.$store.getters['auth/AccessToken']
        )
      }
    },
    data: () => ({
      btnLoading: false,
      //form
      form_valid: true,
      form_error: false,
      formlogin: {
        username: '',
        password: '',
      },
      rule_username: [
        (value) => !!value || 'Kolom Username mohon untuk diisi !!!',
      ],
      rule_password: [
        (value) => !!value || 'Kolom Password mohon untuk diisi !!!',
      ],
    }),
    methods: {
      doLogin: async function () {
        if (this.$refs.frmlogin.validate()) {
          this.btnLoading = true
          await this.$ajax
            .post('/auth/login', {
              username: this.formlogin.username,
              password: this.formlogin.password,
            })
            .then(({ data }) => {
              this.$ajax
                .get('/auth/me', {
                  headers: {
                    Authorization: data.token_type + ' ' + data.access_token,
                  },
                })
                .then((response) => {
                  var data_user = {
                    token: data,
                    user: response.data,
                  }
                  this.$store.dispatch('auth/afterLoginSuccess', data_user)
                })
              this.btnLoading = false
              this.form_error = false
              this.$router.push('/dashboard/' + data.access_token)
            })
            .catch(() => {
              this.form_error = true
              this.btnLoading = false
            })
        }
      },
    },
    components: {
      FrontLayout,
    },
  }
</script>
