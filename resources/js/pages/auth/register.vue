<template>
  <div class="login-container container-fluid d-flex justify-content-center align-items-center">
    <div class="login-body text-left">
      <div class="lc-logo justify-content-center align-items-center d-flex pt-5">
          <img src="/asset/img/icon/logo.png" alt="">
      </div>
      <Divider />
      <div class="lc-title">
          <h4 class="p-3"><strong>{{$t('register').register}}</strong></h4>
      </div>
      <Form :model="verifyData" >
        <div class="lc-form px-4">
            <div class="m-2">
                <p class="mt-2">{{ $t('common').name }} </p>
                <Input prefix="md-person" v-model="verifyData.name" type="text" name="name" :disabled="isSentVercode" :placeholder="$t('placeholder').enterName"/>
            </div>
            <div class="m-2">
                <p class="mt-2">{{ $t('common').email }} </p>
                <Input prefix="ios-mail-outline" v-model="verifyData.email" type="email" name="email" :disabled="isSentVercode" :placeholder="$t('placeholder').enterEmail"/>
            </div>
            <div class="m-2">
                <p class="mt-2">{{ $t('apartment').phoneNumber }}</p>
                <Input prefix="ios-phone-portrait" v-model="verifyData.phone" type="tel" name="phone" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" :disabled="isSentVercode" :placeholder="$t('placeholder').enterPhone"/>
            </div>
            <div class="m-2">
              <Button v-if="isSentVercode == false" class="mt-3" long icon="ios-send" type="success" @click="verifyUserInfo" :disabled="isConfirming" :loading="isConfirming">{{ $t('common').request }}</Button>
            </div>

            <div class="m-2 animate__animated animate__fadeIn d-flex justify-content-center" v-if="isSentVercode">
              <p class="mr-3">{{dong}} {{ $t('auth').dong }}</p>
              <p>{{ho}} {{ $t('auth').ho }}</p>
            </div>
            <div class="m-2 animate__animated animate__fadeIn" v-if="isSentVercode">
                <p class="mt-2">{{ $t('auth').verificationCode }}</p>
                <Input prefix="md-finger-print" class="d-block" v-model="verifyCode.code" name="vercode" maxlength="6" :disabled="isFinishVerify" :placeholder="$t('placeholder').enterCode"/>
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
            <div class="m-2 animate__animated animate__fadeIn" v-if="isFinishVerify" style="width:200px;">
                <Checkbox v-model="isAgree">{{ $t('auth').IagreeHomey }} <router-link :to="{ name: 'term' }" target='_blank'>{{ $t('auth').TermsofService }}</router-link> {{ $t('common').and }}<router-link :to="{ name: 'privacy' }" target= '_blank'>{{ $t('auth').PrivacyPolicy }}</router-link></Checkbox>
            </div>
            <div class="m-2 animate__animated animate__fadeIn">
              <Button v-if="isFinishVerify" class="mt-3 " icon="ios-send" type="success" long @click="setPassword" :disabled="isSettingPassword" :loading="isSettingPassword">{{ $t('common').setPassword }}</Button>
            </div>
        </div>
      </Form>
      <div class="m-2 text-center py-3">
          <p>{{ $t('auth').Youhaveaccount }}
            <router-link :to="{ name: 'login' }">
              {{ $t('auth').loginHere }}
            </router-link>
          </p>
      </div>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'
import {postValidation, verifyingCodeFromEmail, setupPassword} from '~/api/auth'
import i18n from '~/plugins/i18n'
export default {
  middleware: 'guest',

  components: {
    LoginWithGithub
  },

  metaInfo () {
    return { title: this.$t('register').register }
  },

  data: () => ({
    
    isConfirming:false,
    isAgree:false,
    verifyData:{
      name:'',
      email:'',
      phone:'',
    },
    isSentVercode: false,
    verifyCode: {
      code:'',
      userData: {}
    },
    dong:'',
    ho:'',
    isVerifying:false,
    isFinishVerify: false,
    password : {
      password:'',
      confirmpassword:''
    },
    isSettingPassword:false,
  }),

  methods: {
    async verifyUserInfo(){
      if(this.verifyData.name.trim() == ''){
        return this.error(i18n.t('alert').name);
      }
      if(this.verifyData.email.trim() == ''){
        return this.error(i18n.t('alert').email);
      }
      if(this.verifyData.phone.trim() == ''){
        return this.error(i18n.t('alert').phone);
      }

      this.isConfirming = true;
      await postValidation(this.verifyData)
      .then(res=>{
        if(res.data.msg = "ok"){
          this.dong = res.data.dong;
          this.ho = res.data.ho;
          this.isSentVercode = true;
        }
      })
      .catch(err=>{
        this.error(i18n.t('alert').checkAgainYouEntered);
      });
      this.isConfirming = false;
    },

    async verifyingCode(){
      if(this.verifyCode.code.trim() == ''){
        return this.error(i18n.t('alert').code);
      }
      this.verifyCode.userData = this.verifyData;
      this.isVerifying = true;
      await verifyingCodeFromEmail(this.verifyCode)
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
      if(this.isAgree == false){
        return this.error(i18n.t('alert').agreePolicy);
      }
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
      await setupPassword(this.password.password, this.verifyData)
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
