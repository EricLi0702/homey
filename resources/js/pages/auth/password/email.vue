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
      <div class="lc-form px-4 pb-5">
        <div class="m-2">
            <p class="mt-2">{{ $t('common').email }} </p>
            <Input prefix="ios-mail-outline" v-model="userEmail" type="email" name="email" :disabled="isSentVercode" :placeholder="$t('auth').enterEmail"/>
        </div>
        <div class="m-2">
          <Button v-if="isSentVercode == false" class="mt-3" long icon="ios-send" type="success" @click="verifyUserEmail" :disabled="isConfirming" :loading="isConfirming">{{ $t('common').sendResetPassLink }}</Button>
        </div>
        <div class="m-2 animate__animated animate__fadeIn" v-if="isSentVercode">
          <p class="mt-2">{{ $t('auth').verificationCode }}</p>
          <Input prefix="md-finger-print" class="d-block" v-model="verifyCode.code" name="vercode" maxlength="6" :disabled="isFinishVerify" />
          <p>{{ $t('auth').verificationEmailCode }}</p>
          <Button class="mt-3" icon="ios-send" type="success" long @click="verifyingCode" :disabled="isVerifying||isFinishVerify" :loading="isVerifying">{{ $t('auth').verify }}</Button>
        </div>
        <div class="m-2 animate__animated animate__fadeIn" v-if="isFinishVerify">
          <p class="mt-2">{{ $t('common').password }}</p>
          <Input prefix="ios-key-outline" v-model="password.password" type="password" password name="password" :placeholder="$t('auth').enterPass"/>
        </div>
        <div class="m-2 animate__animated animate__fadeIn" v-if="isFinishVerify">
          <p class="mt-2">{{ $t('common').confirmPassword }}</p>
          <Input prefix="ios-key-outline" v-model="password.confirmpassword" type="password" password name="confirmpassword" :placeholder="$t('auth').enterConfirmPass"/>
        </div>
        <div class="m-2 animate__animated animate__fadeIn">
          <Button v-if="isFinishVerify" class="mt-3 " icon="ios-send" type="success" long @click="setPassword" :disabled="isSettingPassword" :loading="isSettingPassword">{{$t('common').resetPass}}</Button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import {verifyUserEmailResetPass, verifyingCodeFromEmailResetPass, setupPasswordResetPass} from '~/api/auth'
import i18n from '~/plugins/i18n'
export default {
  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('metaInfo').reset_password }
  },

  data: () => ({
    status: '',
    form: new Form({
      email: ''
    }),
    userEmail: '',
    isFinishVerify:false,
    isSentVercode:false,
    isConfirming:false,
    isVerifying:false,
    isSettingPassword:false,
    verifyCode: {
      code:'',
      userEmail: ''
    },
    password : {
      password:'',
      confirmpassword:''
    },
  }),

  methods: {

    async send () {
      const { data } = await this.form.post('/api/password/email')
      this.status = data.status
      this.form.reset()
    },

    verifyUserEmail(){
      if(this.userEmail.trim() == ''){
         return this.error(i18n.t('alert').email);
      }
      let mailFormat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
      if(!(this.userEmail.match(mailFormat))){
        this.userEmail = ''
        return this.error(i18n.t('alert').invalidEmail);
      }
      this.isConfirming = true;
      let obj ={
        email : this.userEmail
      }
      verifyUserEmailResetPass(obj)
      .then(res=>{
        if (res.data.msg == 2){
          this.isConfirming = false;
          this.isSentVercode = true;
        }
      })
      .catch(err=>{
        console.log(err.response)
        if(err.response.data.msg == 0){
          this.isConfirming = false;
          this.error(i18n.t('alert').emailNotFound);
        }
        if(err.response.data.msg == 1){
          this.isConfirming = false;
          this.error(i18n.t('alert').firstMustRegister);
        }
      })
    },

    async verifyingCode(){
      if(this.verifyCode.code.trim() == ''){
        return this.error(i18n.t('alert').code);
      }
      this.verifyCode.userEmail = this.userEmail;
      this.isVerifying = true;
      await verifyingCodeFromEmailResetPass(this.verifyCode)
      .then(res=>{
        if(res.data.msg = "ok"){
          this.isFinishVerify = true;
        }
      })
      .catch(err=>{
        this.error(i18n.t('alert').checkAgainYouEnteredCode);
      });
      this.isVerifying = false;
    },

    async setPassword(){
      if(this.password.password.trim() == ''){
        return this.error(i18n.t('alert').password);
      }
      if(this.password.confirmpassword.trim() == ''){
        return this.error(i18n.t('alert').passwordConfirm);
      }
      if(this.password.password !== this.password.confirmpassword){
        this.password.confirmpassword = '';
        return this.error(i18n.t('alert').notMatchPass);
      }
      this.isSettingPassword = true;
      await setupPasswordResetPass(this.password.password, this.userEmail)
      .then(res=>{
        if(res.data.msg = "ok"){
          this.$router.push({ name: 'login' })
        }
      })
      .catch(err=>{
        console.log(err.response);
      });

      this.isSettingPassword = false;
    },
  }
}
</script>
