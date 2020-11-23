<template>
  <div class="login-container container-fluid d-flex justify-content-center align-items-center">
    <div class="login-body text-left">
      <div class="lc-logo justify-content-center align-items-center d-flex pt-5">
          <img src="/asset/img/icon/logo.png" alt="">
      </div>
      <Divider />
      <div class="lc-title">
          <h4 class="p-3"><strong>{{$t('login').login}}</strong></h4>
      </div>
      <form @submit.prevent="login" @keydown="form.onKeydown($event)">
        <div class="lc-form px-4">
            <div class="m-2">
                <p class="mt-2">{{ $t('common').email }} </p>
                <Input prefix="ios-mail-outline" v-model="form.email" type="email" name="email" :class="{ 'is-invalid': form.errors.has('email') }" :placeholder="$t('auth').enterEmail"/>
                <has-error :form="form" field="email" />
            </div>
            <div class="m-2">
                <div class="d-flex">
                    <p class="mt-2">{{ $t('common').password }} </p>
                    <router-link :to="{ name: 'password.request' }" class="small ml-auto my-auto mt-2 ml-auto">
                      {{ $t('common').forgotPassword }}
                    </router-link>
                </div>
                <Input prefix="ios-key-outline" v-model="form.password" type="password" password name="password" :placeholder="$t('auth').enterPass" :class="{ 'is-invalid': form.errors.has('password') }"/>
                <has-error :form="form" field="password" />
            </div>
            <div class="m-2">
                <checkbox v-model="remember" name="remember">
                  {{ $t('common').rememberMe }}
                </checkbox>
            </div>
            <div class="m-2">
              <v-button class="w-100" :loading="form.busy">
                {{ $t('login').login }}
              </v-button>
            </div>
            <div class="m-2 text-center">
                <p>{{ $t('auth').loginWithSocial }}</p>
            </div>
            <div class="m-2 d-flex justify-content-between">
                <Button class="w-49 mr-auto facebook-login-btn" icon="logo-facebook">{{ $t('auth').facebook }}</Button>
                <login-with-google />
            </div>
            <div class="m-2 text-center py-3">
                <p>{{ $t('auth').DontHaveAnAccount }}
                  <router-link :to="{ name: 'register' }">
                    {{ $t('auth').createOne }}
                  </router-link>
                </p>
            </div>
        </div>
      </form>
    </div>
  </div>
  
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'
import LoginWithGoogle from '~/components/LoginWithGoogle'
import i18n from '~/plugins/i18n'
export default {
  middleware: 'guest',

  components: {
    LoginWithGithub,
    LoginWithGoogle
  },

  metaInfo () {
    return { title: this.$t('login').login }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false,
    resData:null
  }),

  methods: {
    async login () {
      if (this.form.password.trim() == '' || this.form.email.trim() == ''){
        return this.error(i18n.t('alert').loginField);
      }
      // Submit the form.
      const data = {}
      await this.form.post('/api/login')
        .then(res=>{
          this.resData  = res.data
        })
        .catch(err=>{
          this.error(i18n.t('alert').loginFailed);
        })
      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: this.resData.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.$router.push({ name: 'home' })
    }
  }
}
</script>
