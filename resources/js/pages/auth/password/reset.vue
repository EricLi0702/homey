<template>
<div class="reset-pass-container container-fluid d-flex justify-content-center align-items-center">
    <div class="reset-pass-body text-left">
      <div class="lc-logo justify-content-center align-items-center d-flex pt-5">
          <img src="/asset/img/icon/logo.png" alt="">
      </div>
      <Divider />
      <div class="lc-title">
          <h4 class="p-3"><strong>
            {{ $t('auth').resetPassword }}
          </strong></h4>
      </div>
      <form @submit.prevent="reset" @keydown="form.onKeydown($event)">
        <div class="lc-form px-4">
            <alert-success :form="form" :message="status" />
            <div class="m-2">
                <p class="mt-2">{{ $t('common').email }}</p>
                <Input prefix="ios-mail-outline" v-model="form.email" type="email" name="email" :class="{ 'is-invalid': form.errors.has('email') }" disabled/>
                <has-error :form="form" field="email" />
            </div>
            <div class="m-2">
                <p class="mt-2">{{ $t('common').password }} </p>
                <Input prefix="ios-key-outline" v-model="form.password" type="password" password name="password" :class="{ 'is-invalid': form.errors.has('password') }" :placeholder="$t('auth').enterPass"/>
                <has-error :form="form" field="password" />
            </div>
            <div class="m-2">
                <p class="mt-2">{{ $t('common').confirmPassword }} </p>
                <Input prefix="ios-key-outline" v-model="form.password_confirmation" password type="password" name="password_confirmation" :class="{ 'is-invalid': form.errors.has('password') }" :placeholder="$t('auth').enterConfirmPass"/>
                <has-error :form="form" field="password_confirmation" />
            </div>
            
            <div class="m-2">
              <v-button :loading="form.busy" class="mt-3 mb-5 w-100">
                {{ $t('common').resetPass }}
              </v-button>
            </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Form from 'vform'

export default {
  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('metaInfo').reset_password }
  },

  data: () => ({
    status: '',
    form: new Form({
      token: '',
      email: '',
      password: '',
      password_confirmation: ''
    })
  }),

  created () {
    this.form.email = this.$route.query.email
    this.form.token = this.$route.params.token
  },

  methods: {
    async reset () {
      const { data } = await this.form.post('/api/password/reset')

      this.status = data.status

      this.form.reset()
    }
  }
}
</script>
