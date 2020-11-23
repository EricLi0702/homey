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
            <label for="staticEmail" class="col-sm-2 col-form-label">UserName</label>
            <div class="col-sm-10">
                <input type="text" id="userName" v-model="userData.name" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" id="userEmail" v-model="userData.email" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">phoneNumber</label>
            <div class="col-sm-10">
                <input type="text" id="userName" v-model="userData.phoneNumber" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Building</label>
            <div class="col-sm-10">
                <select class="mdb-select md-form" v-model="userData.buildingId">
                    <option v-for="building in currentUser.apt.building" :key="building.id" :value="building.id">{{building.number}}</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Ho</label>
            <div class="col-sm-10">
                <input type="text" v-model="userData.ho" class="form-control" id="phoneNumber" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">UserRole</label>
            <div class="col-sm-10">
                <select class="mdb-select md-form" v-model="userData.roleId">
                    <option v-for="role in userRole" :key="role.id" :value="role.id" v-if="role.id > 2">{{role.roleName}}</option>
                </select>
            </div>
        </div>
        <Button class="float-right" type="success" @click="updateUser" :loading="isUpdating" :disabled="isUpdating">Update</Button>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import {fetchUserRole} from '~/api/permission'
import {updateUser} from '~/api/user'
import i18n from '~/plugins/i18n'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').updateUserInfo }
    },
    props:{
        userData:Object
    },
    data(){
        return{
            isUpdating:false,
            userRole:[],
        }
    },
    computed: mapGetters({
        currentUser: 'auth/user'
    }),
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
        updateUser(){
            if(this.userData.name.trim() == ''){
                return this.error(i18n.t('alert').name);
            }
            if(this.userData.email.trim() == ''){
                return this.error(i18n.t('alert').email);
            }
            if(this.userData.phoneNumber.trim() == ''){
                return this.error(i18n.t('alert').phone);
            }
            if(this.userData.buildingId == ''){
                return this.error(i18n.t('alert').dong);
            }
            if(this.userData.ho.trim() == ''){
                return this.error(i18n.t('alert').ho);
            }
            if(this.userData.roleId == ''){
                return this.error(i18n.t('alert').userRole);
            }
            this.isUpdating = true;
            updateUser(this.userData)
            .then(res=>{
                this.isUpdating = false;
                this.userData.name = '' 
                this.userData.email = ''
                this.userData.phoneNumber = ''
                this.userData.buildingId = ''
                this.userData.ho = ''
                this.userData.roleId = ''
                this.$router.push({path:'/user'})
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
            this.isUpdating = false;
        }
    }
}
</script>

<style>

</style>