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
                        <Button type="error" size="small" @click="delRole(role,i)">{{ $t('apartment').delete }}</Button>
                    </td>
                </tr>
            </template>
        </table>
        <Modal
            v-model="addModal"
            title="Add Role"
        >
            <Input v-model="addData.roleName" class="mb-2" placeholder="Enter something..."/>
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
            roleLists:[],
        }
    },
    mounted(){
        fetchUserRole()
            .then(res=>{
                console.log(res.data)
                this.roleLists = res.data
            })
            .catch(err=>{
                console.log(err)
            })
    },
    methods:{
        addRole(){
            // if(this.addData.roleName.trim() == ''){
            //     return this.warning('roleName is required')
            // }
            console.log(this.addData.roleName)
            this.isAdding = true            
            addUserRole(this.addData)
                .then(res=>{
                    console.log(res)
                    this.success('Role is Added')
                    this.roleLists.unshift(res.data)
                    this.addData.roleName = ''
                })
                .catch(err=>{
                    this.swr()
                    console.log(err)
                })
            this.isAdding = false
            this.addModal = false
        },
        editRole(role,index){
            console.log(role)
            this.$set(role,'isEditing',true)
        },
        updateRole(role,index){
            console.log(role)
            if(role.roleName.trim() == ''){
                return this.error('roleName is required')
            }
            this.isEditing = true
            updateUserRole(role)
                .then(res=>{
                    console.log(res)
                    role.isEditing = false

                })
                .catch(err=>{
                    console.log(err)
                })
            this.isEditing = false
        },
        delRole(role,index){
            console.log(role)
            delUserRole(role)
                .then(res=>{
                    console.log(res)
                    this.roleLists.splice(index,1)
                })
                .catch(err=>{
                    console.log(err)
                })
        }
    }
}
</script>