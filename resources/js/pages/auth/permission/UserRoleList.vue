<template>
    <div class="m-2 py-5 gray-input">
        <Button class="mb-4" type="info" size="small" @click="addModal = true">Add</Button>
        <table class="table">
            <tr>
                <th>{{ $t('apartment').id }}</th>
                <th>{{ $t('common').name }}</th>
                <th>{{ $t('apartment').createdAt }}</th>
                <th>{{ $t('apartment').action }}</th>
            </tr>
            <template v-if="roleLists && roleLists.length > 0">
                <tr v-for="(role,i) in roleLists" :key="i">
                    <td>{{role.id}}</td>
                    <td v-if="role.isEditing == undefined || role.isEditing == false">{{role.roleName}}</td>
                    <td v-else-if="role.isEditing == true"><Input v-model="role.roleName" style="width:220px"/></td>
                    <td>{{TimeView(role.created_at)}}</td>
                    <td class="d-flex">
                        <Button v-if="role.isEditing == undefined || role.isEditing == false" type="info" size="small" @click="editRole(role,i)">{{ $t('apartment').edit }}</Button>
                        <Button v-else-if="role.isEditing == true" type="info" size="small" @click="updateRole(role,i)" :disabled="isEditing" :loading="isEditing">{{ $t('auth').update }}</Button>
                        <Button type="error" size="small" @click="openRemoveModal(role)">{{ $t('apartment').delete }}</Button>
                    </td>
                </tr>
            </template>
        </table>
        <Modal v-model="removeModal" width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span v-if="deleteRoleData != null">{{$t('modal').delete}} {{deleteRoleData.roleName}}</span>
            </p>
            <div class="text-center">
                <p>{{$t('modal').willDeleteRole}}</p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loading="isDeleting" @click="delRole()">{{ $t('apartment').delete }}</Button>
            </div>
        </Modal>
        <Modal
            v-model="addModal"
            title="Add Role"
        >
            <Input v-model="addData.roleName" class="mb-2" :placeholder="$t('placeholder').enterUserRole"/>
            <div slot="footer">
                <Button type="default" @click="addModal=false">{{ $t('auth').close }}</Button>
                <Button type="primary" @click="addRole" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding': 'Add Role'}}</Button>
            </div>
        </Modal>
    </div>
</template>

<script>
import {mapGetters,mapAction} from 'vuex'
import {fetchUserRole,addUserRole,updateUserRole,delUserRole} from '~/api/permission'
import permission from '~/json/assignRole.json'
import i18n from '~/plugins/i18n'
export default {
    middleware: 'auth',

    metaInfo () {
        return { title: this.$t('userRole') }
    },

    data(){
        return{
            addModal:false,
            addData:{
                roleName:'',
                permission
            },
            isAdding:false,
            isEditing:false,
            isDeleting:false,
            roleLists:[],
            removeModal : false,
            deleteRoleData:null,
        }
    },
    mounted(){
        fetchUserRole()
            .then(res=>{
                this.roleLists = res.data
            })
            .catch(err=>{
                console.log(err)
            })
    },
    methods:{
        openRemoveModal(role){
            this.deleteRoleData = role;
            this.removeModal = true;
        },
        addRole(){
            this.isAdding = true            
            addUserRole(this.addData)
                .then(res=>{
                    this.roleLists.push(res.data)
                    this.addData.roleName = ''
                    this.success(i18n.t('alert').roleAdded);
                })
                .catch(err=>{
                    this.swr()
                    console.log(err)
                })
            this.isAdding = false
            this.addModal = false
        },
        editRole(role,index){
            this.$set(role,'isEditing',true)
        },
        updateRole(role,index){
            if(role.roleName.trim() == ''){
                return this.error(i18n.t('alert').userRole);
            }
            this.isEditing = true
            updateUserRole(role)
                .then(res=>{
                    role.isEditing = false
                })
                .catch(err=>{
                    console.log(err)
                })
            this.isEditing = false
        },
        delRole(){
            this.isDeleting = true;
            delUserRole(this.deleteRoleData)
                .then(res=>{
                    this.removeModal = false;
                    this.isDeleting = false;
                    this.roleLists.pop(this.deleteRoleData);
                    this.deleteRoleData = null;
                    this.success(i18n.t('alert').removeSuccessfully);
                })
                .catch(err=>{
                    console.log(err)
                })
        }
    }
}
</script>