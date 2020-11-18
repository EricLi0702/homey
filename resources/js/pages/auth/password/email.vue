<template>
<div class="reset-pass-container container-fluid d-flex justify-content-center align-items-center">
    <div class="reset-pass-body text-left">
      <div class="lc-logo justify-content-center align-items-center d-flex pt-5">
          <img src="/asset/img/icon/logo.png" alt="">
      </div>
      <Divider />
      <div class="lc-title">
          <h4 class="p-3"><strong>
            {{$t('common').resetPass}}
          </strong></h4>
      </div>
      <form @submit.prevent="send" @keydown="form.onKeydown($event)">
        <div class="lc-form px-4">
            <alert-success :form="form" :message="status" />
            <div class="m-2">
                <p class="mt-2">{{ $t('common').email }} </p>
                <Input prefix="ios-mail-outline" v-model="form.email" type="email" name="email" :class="{ 'is-invalid': form.errors.has('email') }" :placeholder="$t('auth').enterEmail"/>
                <!-- <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email"> -->
                <has-error :form="form" field="email" />
            </div>
            
            <div class="m-2">
              <v-button :loading="form.busy" class="mt-3 mb-5 w-100">
                {{ $t('common').sendResetPassLink }}
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
    return { title: this.$t('metaInfo').reset_password }
  },

  data: () => ({
    status: '',
    form: new Form({
      email: ''
    })
  }),

  methods: {
    async send () {
      const { data } = await this.form.post('/api/password/email')

      this.status = data.status

      this.form.reset()
    }
  }
}
</script>
