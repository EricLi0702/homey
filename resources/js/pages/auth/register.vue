<template>
  <div class="login-container container-fluid d-flex justify-content-center align-items-center">
    <div class="login-body text-left">
      <div class="lc-logo justify-content-center align-items-center d-flex pt-5">
          <img src="/asset/img/icon/logo.png" alt="">
      </div>
      <Divider />
      <!-- <card v-if="mustVerifyEmail" :title="$t('register')">
        <div class="alert alert-success" role="alert">
          {{ $t('verify_email_address') }}
        </div>
      </card> -->
      <div class="lc-title">
          <h4 class="p-3"><strong>{{$t('register').register}}</strong></h4>
      </div>
      <Form :model="verifyData" >
        <div class="lc-form px-4">
            <div class="m-2">
                <p class="mt-2">{{ $t('common').name }} </p>
                <Input prefix="md-person" v-model="verifyData.name" type="text" name="name" :disabled="isSentVercode" />
            </div>
            <div class="m-2">
                <p class="mt-2">{{ $t('common').email }} </p>
                <Input prefix="ios-mail-outline" v-model="verifyData.email" type="email" name="email" :disabled="isSentVercode" />
            </div>
            <div class="m-2">
                <p class="mt-2">{{ $t('apartment').phoneNumber }}</p>
                <Input prefix="ios-phone-portrait" v-model="verifyData.phone" type="tel" name="phone" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" :disabled="isSentVercode" />
            </div>
            <div class="m-2">
              <!-- <v-button class="w-100" :loading="form.busy">
                {{ $t('register').register }}
                confirm
              </v-button> -->
              <Button v-if="isSentVercode == false" class="mt-3" long icon="ios-send" type="success" @click="verifyUserInfo" :disabled="isConfirming" :loading="isConfirming">{{ $t('common').request }}</Button>
            </div>
            <div class="m-2 animate__animated animate__fadeIn" v-if="isSentVercode">
                <p class="mt-2">{{ $t('auth').verificationCode }}</p>
                <Input prefix="md-finger-print" class="d-block" v-model="verifyCode.code" name="vercode" maxlength="6" :disabled="isFinishVerify" />
                <Button class="mt-3" icon="ios-send" type="success" long @click="verifyingCode" :disabled="isVerifying||isFinishVerify" :loading="isVerifying">{{ $t('auth').verify }}</Button>
            </div>
            <div class="m-2 animate__animated animate__fadeIn" v-if="isFinishVerify">
                <p class="mt-2">password{{ $t('common').rememberMe }}</p>
                <Input prefix="ios-key-outline" v-model="password.password" type="password" password name="password" placeholder="Enter password"/>
            </div>
            <div class="m-2 animate__animated animate__fadeIn" v-if="isFinishVerify">
                <p class="mt-2">{{ $t('common').confirmPassword }}</p>
                <Input prefix="ios-key-outline" v-model="password.confirmpassword" type="password" password name="confirmpassword" placeholder="Enter confirm password"/>
            </div>
            <div class="m-2 animate__animated animate__fadeIn" v-if="isFinishVerify" style="width:200px;">
                <Checkbox v-model="isAgree">{{ $t('auth').IagreeHomey }} <router-link :to="{ name: 'term' }" target='_blank'>{{ $t('auth').TermsofService }}</router-link> and {{ $t('common').rememberMe }}<router-link :to="{ name: 'privacy' }" target= '_blank'>{{ $t('auth').PrivacyPolicy }}</router-link></Checkbox>
            </div>
            <div class="m-2 animate__animated animate__fadeIn">
              <Button v-if="isFinishVerify" class="mt-3 " icon="ios-send" type="success" long @click="setPassword" :disabled="isSettingPassword" :loading="isSettingPassword">Set Password</Button>
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
        return this.error('Name is required');
      }
      if(this.verifyData.email.trim() == ''){
        return this.error('Email is required');
      }
      if(this.verifyData.phone.trim() == ''){
        return this.error('Phone is required');
      }

      this.isConfirming = true;
      await postValidation(this.verifyData)
      .then(res=>{
        if(res.data.msg = "ok"){
          this.isSentVercode = true;
        }
      })
      .catch(err=>{
        this.error('Please check again if the information you entered is correct.');
      });
      this.isConfirming = false;
    },

    async verifyingCode(){
      if(this.verifyCode.code.trim() == ''){
        return this.error('Code is required');
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
        this.error('please check again if the code you entered is correct');
      });
      this.isVerifying = false;
    },

    async setPassword(){
      if(this.isAgree == false){
        return this.error('please agree to our Terms of Service and Privacy Policy');
      }
      if(this.password.password.trim() == ''){
        return this.error('Password is required');
      }
      if(this.password.confirmpassword.trim() == ''){
        return this.error('Confirm Password is required');
      }
      if(this.password.password !== this.password.confirmpassword){
        this.password.confirmpassword = '';
        return this.error('Password does not match. please try again');
      }
      console.log("password", this.password);
      this.isSettingPassword = true;
      await setupPassword(this.password.password, this.verifyData)
      .then(res=>{
        if(res.data.msg = "ok"){
          this.$router.push({ name: 'login' })
        }
      })
      .catch(err=>{
        this.error('please check again if the code you entered is correct');
      });

      this.isSettingPassword = false;
    },
  }
}
</script>
