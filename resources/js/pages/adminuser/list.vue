<template>
    <div class="m-2 py-3">
        <div>
            <Select v-model="selectedAptId" style="width:200px" @on-change="triggerAptId()">
                <Option v-for="Apt in aptLists" :value="Apt.id" :key="Apt.id">{{ Apt.aptName }}</Option>
            </Select>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <div class="text-center">
                <h1>{{currentApt.aptName}}</h1>
                <p>{{currentApt.code}}</p>
                <p>{{currentApt.address}}</p>
            </div>
        </div>
        <div class="manager-list mt-3">
            <div class="supermanager-list row justify-content-center">
                <div v-for="(supermanager, i) in superManagerData" :key="i" class="col-4 text-center mb-4">
                    <div class="manager-card-container p-3 m-1">
                        <img :src="`${baseUrl}/asset/img/icon/supermanager_${currentLang}.png`" class="rounded-circle ribbon-banner mr-2" alt="">
                        <div class="manager-avatar">
                            <img :src="`${baseUrl}${supermanager.user_avatar}`" class="rounded-circle user-list-photo mr-2" alt="">
                        </div>
                        <div class="manager-info">
                            <div class="manager-name-info">
                                <h5>{{supermanager.name}}</h5>
                            </div>
                            <div class="manager-email-info d-flex align-items-center justify-content-center">
                                <Icon type="ios-mail-outline" size="20"/>
                                <p>{{supermanager.email}}</p>
                            </div>
                            <div class="manager-phoneNumber-info d-flex align-items-center justify-content-center">
                                <Icon type="md-call" size="20" />
                                <p>{{supermanager.phoneNumber}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="supermanager-list row justify-content-center">
                <div v-for="(notiManager, i) in notiManagerData" :key="i" class="col-4 text-center mb-4">
                    <div class="manager-card-container p-3 m-1">
                        <img :src="`${baseUrl}/asset/img/icon/notimanager_${currentLang}.png`" class="rounded-circle ribbon-banner mr-2" alt="">
                        <div class="manager-avatar">
                            <img :src="`${baseUrl}${notiManager.user_avatar}`" class="rounded-circle user-list-photo mr-2" alt="">
                        </div>
                        <div class="manager-info">
                            <div class="manager-name-info">
                                <h5>{{notiManager.name}}</h5>
                            </div>
                            <div class="manager-email-info d-flex align-items-center justify-content-center">
                                <Icon type="ios-mail-outline" size="20"/>
                                <p>{{notiManager.email}}</p>
                            </div>
                            <div class="manager-phoneNumber-info d-flex align-items-center justify-content-center">
                                <Icon type="md-call" size="20" />
                                <p>{{notiManager.phoneNumber}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="supermanager-list row justify-content-center">
                <div v-for="(repairManager, i) in repairManagerData" :key="i" class="col-4 text-center mb-4">
                    <div class="manager-card-container p-3 m-1">
                        <img :src="`${baseUrl}/asset/img/icon/repairmanager_${currentLang}.png`" class="rounded-circle ribbon-banner mr-2" alt="">
                        <div class="manager-avatar">
                            <img :src="`${baseUrl}${repairManager.user_avatar}`" class="rounded-circle user-list-photo mr-2" alt="">
                        </div>
                        <div class="manager-info">
                            <div class="manager-name-info">
                                <h5>{{repairManager.name}}</h5>
                            </div>
                            <div class="manager-email-info d-flex align-items-center justify-content-center">
                                <Icon type="ios-mail-outline" size="20"/>
                                <p>{{repairManager.email}}</p>
                            </div>
                            <div class="manager-phoneNumber-info d-flex align-items-center justify-content-center">
                                <Icon type="md-call" size="20" />
                                <p>{{repairManager.phoneNumber}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-centers mt-5">
            <h3>{{$t('metaInfo').ListUser}}</h3>
        </div>
        <table class="table user-list-table mt-4">
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
                        <Icon size="25" type="ios-trash" color="#FD0000" @click="openRemoveModal(user)"/>
                    </td>
                </tr>
            </template>
        </table>
        <div class="d-flex justify-content-center">
            <pagination :limit="3" :data="paginationData" @pagination-change-page="getAdminUserList"></pagination>
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
import {getAdminUserList, delUser} from '~/api/user'
import {getAptLists} from '~/api/apartment'
import {mapGetters} from 'vuex'
import i18n from '~/plugins/i18n'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').userlist }
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
            aptLists:[],
            selectedAptId: 0,
            currentApt:{},
            superManagerData:[],
            notiManagerData:[],
            repairManagerData:[],
        }
    },
    computed:{
        ...mapGetters({
            currentUser:'auth/user',
            currentLang:'lang/locale'
        })
    },
    
    mounted(){
        this.getApt();
        
    },
    methods:{
        
        getApt(){
            getAptLists()
            .then(res=>{
                this.aptLists = res.data;
                this.currentApt = this.aptLists[0];
                this.selectedAptId = this.aptLists[0].id;
                this.getAdminUserList();
            })
            .catch(error=>{
                console.log(error.response);
            })
        },

        getAdminUserList(page = 1){
            let obj = {};
            obj.page = page;
            obj.aptId = this.selectedAptId;
            getAdminUserList(obj)
            .then(res=>{
                this.superManagerData = res.data.superManagerData;
                this.notiManagerData = res.data.notiManagerData;
                this.repairManagerData = res.data.repairManagerData;
                this.paginationData = res.data.commonUserData;
                this.userLists = res.data.commonUserData.data;
            })
            .catch(error=>{
                console.log(error.response);
            })
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
        },
        triggerAptId(){
            for(let i=0; i<this.aptLists.length; i++){
                if(this.selectedAptId == this.aptLists[i].id){
                    this.currentApt = this.aptLists[i];
                }
            }
            this.getAdminUserList();
        }
    }
}
</script>