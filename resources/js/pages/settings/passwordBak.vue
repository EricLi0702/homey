<template>
  <div class="container-fluid bg-light-gray m-0 p-0 pb-5">
    <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
      <div class="p-3 py-5">
        <h2 class="p-3">{{$t('auth').resetPassword}}</h2>
        <form @submit.prevent="update" @keydown="form.onKeydown($event)">
          <div class="row m-0 p-0">
            <div class="col-12 mb-3 gray-input">
              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
              <has-error :form="form" field="password" />
            </div>
            <div class="col-12 mb-3 gray-input">
              <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
              <has-error :form="form" field="password_confirmation" />
            </div>
            
            <div class="col-12 text-left d-flex justify-content-start mt-3 position-relative">
              <v-button :loading="form.busy" type="success">
                {{ $t('auth').update }}
              </v-button>                           
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Form from 'vform'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('metaInfo').reset_password }
  },

  data: () => ({
    form: new Form({
      password: '',
      password_confirmation: ''
    })
  }),

  methods: {
    async update () {
      await this.form.patch('/api/settings/password')

      this.form.reset()
    }
  }
}
</script>
