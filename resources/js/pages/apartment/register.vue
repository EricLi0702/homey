<template>
  <div class="m-2 py-5 gray-input">
    <div class="form-group row">
      <label for="staticEmail" class="col-sm-2 col-form-label">{{ $t('apartment').AptName }}</label>
      <div class="col-sm-10">
        <input type="text" id="aptName" v-model="addData.aptName" class="form-control" :placeholder="$t('placeholder').enterAPTName">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">{{ $t('apartment').address }}</label>
      <div class="col-sm-10">
        <input type="text" id="address" v-model="addData.address" class="form-control" :placeholder="$t('placeholder').enterAPTAddress">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">{{ $t('apartment').representativeName }}</label>
      <div class="col-sm-10">
        <input type="text" id="repreName" v-model="addData.repreName" class="form-control" :placeholder="$t('placeholder').enterAPTRepName">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">{{ $t('apartment').phoneNumber }}</label>
      <div class="col-sm-10">
        <input type="text" v-model="addData.phoneNumber" class="form-control" id="phoneNumber" :placeholder="$t('placeholder').enterAPTRepPhone">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">{{ $t('apartment').eMail }}</label>
      <div class="col-sm-10">
        <input type="email" v-model="addData.email" class="form-control" id="email" :placeholder="$t('placeholder').enterAPTRepEmail">
      </div>
    </div>
    <Button class="float-right" type="success" @click="addApt" :loading="isAdding" :disabled="isAdding">{{ $t('register').register }}</Button>
  </div>
</template>

<script>
import {addApt,getAptLists,updateApt,delApt} from '~/api/apartment'
import i18n from '~/plugins/i18n'
export default {
  data(){
    return{
      addData:{
        aptName:'',
        address:'',
        repreName:'',
        phoneNumber:'',
        email:''
      },
      isAdding:false,
    }
  },
  mounted(){
    getAptLists()
      .then(res=>{
        this.aptLists = res.data
      })
      .catch(err=>{
        console.log(err)
      })
  },
  methods:{
    async  addApt(){
      if(this.addData.aptName.trim() == ''){
        this.error(i18n.t('alert').aptNameRequired);
      }
      if(this.addData.address.trim() == ''){
        this.error(i18n.t('alert').aptAddressRequired);
      }
      if(this.addData.repreName.trim() == ''){
        this.error(i18n.t('alert').aptRepNameRequired);
      }
      if(this.addData.phoneNumber.trim() == ''){
        this.error(i18n.t('alert').aptRepPhoneRequired);
      }
      if(this.addData.email.trim() == ''){
        this.error(i18n.t('alert').aptRepEmailRequired);
      }

      this.isAdding = true
      await addApt(this.addData)
        .then(res=>{
          if(res.status == 201){
            this.isAdding = false
            this.addData.aptName = ''
            this.addData.address = ''
            this.addData.repreName = ''
            this.addData.phoneNumber = ''
            this.addData.email = ''
            this.$router.push({path:'/apartment'})
          }
        })
        .catch(err=>{
          console.log(err)
        })
      this.isAdding = false
    },
  }
}
</script>