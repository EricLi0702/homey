<template>
    <div>
        <Button type="info" size="small" @click="addUser">Register User</Button>
        <table class="table">
        <tr>
            <th>No</th>
            <th>AptName</th>
            <th>AptCode</th>
            <th>UserName</th>
            <th>Email</th>
            <th>PhoneNumber</th>
            <th>Dong</th>
            <th>Ho</th>
            <th>Member</th>
            <th>UserRole</th>
            <th>Crated at</th>
            <th>Action</th>
        </tr>
        <template v-if="userLists && userLists.length > 0">
            <tr v-for="(user,i) in userLists" :key="i">
                <td>{{i+1}}</td>
                <td>{{user.apt.aptName}}</td>
                <td>{{user.aptId}}</td>
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td>{{user.phoneNumber}}</td>
                <td>{{user.apt.building}}</td>
                <td>{{user.ho}}</td>
                <td>{{TimeView(user.created_at)}}</td>
                <td class="d-flex">
                    <Button type="info" size="small" @click="editUser(user,i)">Edit</Button>
                    &nbsp;&nbsp;
                    <Button type="error" size="small" @click="delUser(user,i)" :loading="isDeleting" :disabled="isDeleting">Delete</Button>
                    &nbsp;&nbsp;
                </td>
            </tr>
        </template>
    </table>
    </div>
</template>

<script>
import {getUserList} from '~/api/user'
import {mapGetters} from 'vuex'
export default {
    data(){
        return{
            userLists:[],
            isAdding:false,
            isDeleting:false,
        }
    },
    computed:{
        ...mapGetters({
            currentUser:'auth/user'
        })
    },
    mounted(){
        console.log('@@@@@',this.currentUser.aptId)
        getUserList(this.currentUser.aptId)
        .then(res=>{
                console.log('+++',res.data)
                this.userLists = res.data
            })
            .catch(err=>{
                console.log(err)
            })
    },
    methods:{
        addUser(){
            this.$router.push({path:'register'})
        },
        editUser(user,index){
            this.$router.push({name:'user.details',params:{userData:user}})
        },
        delApt(user,index){
            this.isDeleting = true
            delApt(user)
                .then(res=>{
                    this.success('successfully delted')
                    this.userLists.splice(index,1)
                })
                .catch(err=>{
                    console.log(err)
                })
            this.isDeleting = false
        },
    }
}
</script>

<style>

</style>