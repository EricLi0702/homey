<template>
  <div class="m-2 py-5 gray-input">
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Apt Code</label>
      <div class="col-sm-10">
        {{currentUser.apt.code}}
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Apt Name</label>
      <div class="col-sm-10">
        {{currentUser.apt.aptName}}
      </div>
    </div>
    <div class="form-group row">
      <label for="staticEmail" class="col-sm-2 col-form-label">{{$t('common').name}}</label>
      <div class="col-sm-10">
        <input type="text" id="userName" v-model="user.name" class="form-control" :placeholder="$t('placeholder').enterName">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">{{$t('common').email}}</label>
      <div class="col-sm-10">
        <input type="email" id="userEmail" v-model="user.email" class="form-control" :placeholder="$t('placeholder').enterEmail">
      </div>
    </div>
    <div class="form-group row">
      <label for="staticEmail" class="col-sm-2 col-form-label">{{$t('common').phone}}</label>
      <div class="col-sm-10">
        <input type="text" id="userName" v-model="user.phoneNumber" class="form-control" :placeholder="$t('placeholder').enterPhone">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">{{$t('buildingNumber').apartment}}</label>
      <div class="col-sm-10">
        <select class="mdb-select md-form" v-model="user.buildingId">
          <option v-for="building in currentUser.apt.building" :key="building.id" :value="building.id">{{building.number}}</option>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">{{$t('auth').ho}}</label>
      <div class="col-sm-10">
        <input type="text" v-model="user.ho" class="form-control" id="phoneNumber" placeholder="">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">{{$t('common').userRole}}</label>
      <div class="col-sm-10">
        <select class="mdb-select md-form" v-model="user.roleId">
          <option v-for="role in userRole" :key="role.id" :value="role.id" v-if="role.id > 2">{{role.roleName}}</option>
        </select>
      </div>
    </div>
    <Button class="float-right" type="success" @click="addUser" :loading="isAdding" :disabled="isAdding">Register</Button>
  </div>
</template>

<script>
import {fetchUserRole} from '~/api/permission'
import {addUser} from '~/api/user'
import {mapGetters} from 'vuex'
import i18n from '~/plugins/i18n'
export default {
  metaInfo () {
        return { title: this.$t('metaInfo').registerUser }
    },
  data(){
    return{
      user:{
        aptId:'',
        name:'',
        email:'',
        phoneNumber:'',
        buildingId:'',
        ho:'',
        roleId:''
      },
      isAdding:false,
      userRole:[],
    }
  },
  computed:{
    ...mapGetters({
      currentUser:'auth/user'
    })
  },
  mounted(){
    fetchUserRole()
      .then(res=>{
        this.userRole = res.data
      })
      .catch(err=>{
        console.log(err)
      })
  },
  methods:{
    async  addUser(){
      if(this.user.name.trim() == ''){
        return this.error(i18n.t('alert').name);
      }
      if(this.user.email.trim() == ''){
        return this.error(i18n.t('alert').email);
      }
      if(this.user.phoneNumber.trim() == ''){
        return this.error(i18n.t('alert').phone);
      }
      if(this.user.buildingId == ''){
        return this.error(i18n.t('alert').dong);
      }
      if(this.user.ho.trim() == ''){
        return this.error(i18n.t('alert').ho);
      }
      if(this.user.roleId == ''){
        return this.error(i18n.t('alert').userRole);
      }

      this.user.aptId = this.currentUser.apt.id
      this.isAdding = true
      await addUser(this.user)
        .then(res=>{
          if(res.status == 201){
            this.$router.push({path:'/user'})
          }
        })
        .catch(error => {
          console.log(error.response)
          if(error.response.data.isMail == false){
            this.error(i18n.t('alert').emailAlreadyExist);
          }
          if(error.response.data.isPhone == false){
            this.error(i18n.t('alert').phoneAlreadyExist);
          }
        });
      this.isAdding = false
    },
  }
}
</script>

<style>

</style>