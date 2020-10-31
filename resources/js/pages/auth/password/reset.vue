<template>
<div class="reset-pass-container container-fluid d-flex justify-content-center align-items-center">
    <div class="reset-pass-body text-left">
      <div class="lc-logo justify-content-center align-items-center d-flex pt-5">
          <img src="/asset/img/icon/logo.png" alt="">
      </div>
      <Divider />
      <div class="lc-title">
          <h4 class="p-3"><strong>
            <!-- {{$t('login').login}} -->
            Reset Password
          </strong></h4>
      </div>
      <form @submit.prevent="reset" @keydown="form.onKeydown($event)">
        <div class="lc-form px-4">
            <alert-success :form="form" :message="status" />
            <div class="m-2">
                <p class="mt-2">Email </p>
                <!-- <Input type="email" v-model="data.email" aria-describedby="emailHelp" class="ml-auto" prefix="ios-contact" placeholder="Enter email" style="width: auto" /> -->
                <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email" readonly>
                <has-error :form="form" field="email" />
            </div>
            <div class="m-2">
                <p class="mt-2">Password </p>
                <!-- <Input type="email" v-model="data.email" aria-describedby="emailHelp" class="ml-auto" prefix="ios-contact" placeholder="Enter email" style="width: auto" /> -->
                <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
                <has-error :form="form" field="password" />
            </div>
            <div class="m-2">
                <p class="mt-2">Confirm Password </p>
                <!-- <Input type="email" v-model="data.email" aria-describedby="emailHelp" class="ml-auto" prefix="ios-contact" placeholder="Enter email" style="width: auto" /> -->
                <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
                <has-error :form="form" field="password_confirmation" />
            </div>
            
            <div class="m-2">
              <v-button :loading="form.busy" class="mt-3 mb-5 w-100">
                {{ $t('reset_password') }}
              </v-button>
                <!-- <Button type="primary" long @click="authenticate"  :loading="form.busy">{{ $t('login').login }}</Button> -->
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
    return { title: this.$t('reset_password') }
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
