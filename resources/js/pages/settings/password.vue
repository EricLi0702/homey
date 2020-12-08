<template>
  <div class="container-fluid bg-light-gray m-0 p-0 pb-5">
    <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
      <div class="p-3 py-5">
        <h2 class="p-3">{{$t('auth').resetPassword}}</h2>
        <form @submit.prevent="update" @keydown="form.onKeydown($event)">
          <div class="row m-0 p-0">
            <div class="col-12 mb-3 gray-input">
              <Input @on-enter="updatePassword" v-model="newPassword" type="password" class="customInput w-100" :placeholder="$t('placeholder').enterNewPassword"/>
            </div>
            <div class="col-12 mb-3 gray-input">
              <Input @on-enter="updatePassword" v-model="newPasswordConfrim" type="password" class="customInput w-100" :placeholder="$t('placeholder').enterNewPasswordConfirm"/>
            </div>
            
            <div class="col-12 text-left d-flex justify-content-start mt-3 position-relative">
              <Button type="primary"  @click="updatePassword" :disabled="isLoading" :loading="isLoading">{{$t('auth').resetPassword}}</Button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import i18n from '~/plugins/i18n'
import {updateNewPassword } from '~/api/auth'
export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('metaInfo').reset_password }
  },

  data: () => ({
    form: new Form({
      password: '',
      password_confirmation: ''
    }),
    isLoading:false,
    newPassword:'',
    newPasswordConfrim: '',
  }),

  methods: {
    async update () {
      await this.form.patch('/api/settings/password')

      this.form.reset()
    },

    async updatePassword(){
      if(this.newPassword.trim() == ''){
          return this.error(i18n.t('alert').password);
      }
      if(this.newPasswordConfrim.trim() == ''){
          return this.error(i18n.t('alert').passwordConfirm);
      }
      if(this.newPassword !== this.newPasswordConfrim){
        return this.error(i18n.t('alert').notMatchPass);
      }
      //check if contain number
      if(/\d/.test(this.newPassword) == false){
        return this.error(i18n.t('alert').passwordShouldContainNum);
      }
      //check if contain uppercase
      if(/[A-Z]/.test(this.newPassword) == false){
        return this.error(i18n.t('alert').passwordShouldContainUp);
      }
      //check if contain special character
      if(/[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(this.newPassword) == false){
        return this.error(i18n.t('alert').passwordShouldContainSpec);
      }
      //check if length is more than 8
      if(this.newPassword.length < 8){
        return this.error(i18n.t('alert').passwordShouldLengthEight);
      }

      this.isLoading = true;
      let payload = {
        newPassword : this.newPassword
      }
      updateNewPassword(payload)
      .then(res=>{
        if(res.data.msg == 1){
          this.success(i18n.t('alert').update);
          this.newPassword = '';
          this.newPasswordConfrim = '';
          this.isLoading = false;
        }
      })
      .catch(err=>{
        this.isLoading = false;
        console.log(err.response);
      })
  },
  }
}
</script>
