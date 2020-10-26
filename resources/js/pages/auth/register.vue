<template>
  <div class="login-container container-fluid d-flex justify-content-center align-items-center">
    <div class="login-body text-left">
      <div class="lc-logo justify-content-center align-items-center d-flex pt-5">
          <img src="/asset/img/icon/logo.png" alt="">
      </div>
      <Divider />
      <card v-if="mustVerifyEmail" :title="$t('register')">
        <div class="alert alert-success" role="alert">
          {{ $t('verify_email_address') }}
        </div>
      </card>
      <div class="lc-title">
          <h4 class="p-3"><strong>{{$t('register').register}}</strong></h4>
      </div>
      <form @submit.prevent="register" @keydown="form.onKeydown($event)">
        <div class="lc-form px-4">
            <div class="m-2">
                <p class="mt-2">{{ $t('common').name }} </p>
                <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
                <has-error :form="form" field="name" />
            </div>
            <div class="m-2">
                <p class="mt-2">{{ $t('common').email }} </p>
                <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
                <has-error :form="form" field="email" />
            </div>
            <div class="m-2">
                <p class="mt-2">{{ $t('common').password }}</p>
                <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
                <has-error :form="form" field="password" />
            </div>
            <div class="m-2">
                <p class="mt-2">{{ $t('common').confirmPassword }}</p>
                <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
                <has-error :form="form" field="password_confirmation" />
            </div>
            
            <div class="m-2">
              <v-button class="w-100" :loading="form.busy">
                {{ $t('register').register }}
              </v-button>
                <!-- <Button type="primary" long @click="authenticate"  :loading="form.busy">{{ $t('login').login }}</Button> -->
            </div>

            <div class="m-2 text-center py-3">
                <p>You have already account?
                  <router-link :to="{ name: 'login' }">
                    login here
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

export default {
  middleware: 'guest',

  components: {
    LoginWithGithub
  },

  metaInfo () {
    return { title: this.$t('register').register }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    }),
    mustVerifyEmail: false
  }),

  methods: {
    async register () {
      // Register the user.
      const { data } = await this.form.post('/api/register')

      // Must verify email fist.
      if (data.status) {
        this.mustVerifyEmail = true
      } else {
        // Log in the user.
        const { data: { token } } = await this.form.post('/api/login')

        // Save the token.
        this.$store.dispatch('auth/saveToken', { token })

        // Update the user.
        await this.$store.dispatch('auth/updateUser', { user: data })

        // Redirect home.
        this.$router.push({ name: 'home' })
      }
    }
  }
}
</script>
