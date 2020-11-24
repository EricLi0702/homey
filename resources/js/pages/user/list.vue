<template>
    <div class="m-2 py-3 gray-input">
        <div class="apt-name-code text-center">
            <h2>{{currentUser.apt.aptName}}</h2>
            <p>{{currentUser.apt.code}}</p>
            <p>{{currentUser.apt.address}}</p>
        </div>
        <Button class="mb-4" type="info" size="small" @click="addUser">{{$t('metaInfo').registerUser}}</Button>
        <table class="table user-list-table">
            <tr class="">
                <th>{{$t('common').user}}</th>
                <th>{{$t('auth').dong}} {{$t('auth').ho}}</th>
                <th>{{$t('common').email}}</th>
                <th>{{$t('common').phone}}</th>
                <th>{{$t('common').isUser}}</th>
                <th>{{$t('apartment').action}}</th>
            </tr>
            <template v-if="userLists && userLists.length > 0">
                <tr class="" v-for="(user,i) in userLists" :key="i">
                    <td class="d-flex align-items-center justify-content-start"> 
                        <img :src="`${baseUrl}${user.user_avatar}`" class="rounded-circle user-list-photo mr-2" alt="">
                        <div class="admin-user-list-info">
                            <p class="font-weight-bold">{{user.name}}</p>
                            <Tag color="blue">{{user.role.roleName}}</Tag>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-start">
                            <p class="mr-2">{{user.building.number}}{{ $t('auth').dong }}</p>
                            <p>{{user.ho}}{{ $t('auth').ho }}</p>
                        </div>
                    </td>
                    <td>{{user.email}}</td>
                    <td>{{user.phoneNumber}}</td>
                    <td>
                        <div v-if="user.email_verified_at == null">
                            <Tag color="warning">{{$t('common').notUser}}</Tag>
                        </div>
                        <div v-else>
                            <Tag color="success">{{$t('common').user}}</Tag>
                        </div>
                    </td>
                    <td>
                        <Icon size="25" type="md-create" color="#44B4E2" @click="editUser(user,i)"/>
                        <Icon size="25" type="ios-trash" color="#FD0000" @click="openRemoveModal(user)"/>
                    </td>
                </tr>
            </template>
        </table>
        <div class="d-flex justify-content-center">
            <pagination :limit="3" :data="paginationData" @pagination-change-page="getResults"></pagination>
        </div>

        <Modal v-model="removeModal" width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span v-if="deleteUserData != null">{{$t('modal').delete}} : {{deleteUserData.name}}</span>
            </p>
            <div class="text-center">
                <p>{{$t('modal').willDeleteUser}}</p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="delUser()">{{ $t('apartment').delete }}</Button>
            </div>
        </Modal>
    </div>
</template>

<script>
import {getUserList, delUser} from '~/api/user'
import {mapGetters} from 'vuex'
import i18n from '~/plugins/i18n'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').ListUser }
    },
    data(){
        return{
            baseUrl:window.base_url,
            userLists:[],
            paginationData:{},
            isAdding:false,
            isDeleting:false,
            deleteUserData:null,
            removeModal:false,
        }
    },
    computed:{
        ...mapGetters({
            currentUser:'auth/user'
        })
    },
    mounted(){
        this.getResults();
        
    },
    methods:{
        getResults(page = 1){
            getUserList(page)
            .then(res=>{
                this.userLists = res.data.data
                this.paginationData = res.data
            })
            .catch(err=>{
                console.log(err)
            })
        },
        addUser(){
            this.$router.push({path:'register'})
        },
        editUser(user,index){
            this.$router.push({name:'user.details',params:{userData:user}})
        },
        delUser(){
            this.isDeleting = true;
            delUser(this.deleteUserData.id)
                .then(res=>{
                    this.removeModal = false;
                    this.isDeleting = false;
                    this.userLists.pop(this.deleteUserData);
                    this.deleteUserData = null;
                    this.success(i18n.t('alert').removeSuccessfully);
                })
                .catch(err=>{
                    console.log(err)
                })
        },
        openRemoveModal(user){
            this.deleteUserData = user;
            this.removeModal = true;
        }
    }
}
</script>