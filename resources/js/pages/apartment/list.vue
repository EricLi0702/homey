<template>
    <div class="m-2 py-5">
        <Button class="mb-4" type="info" size="small" @click="addApt">Add Apartment</Button>
        <table class="table m-0">
        <tr>
            <th>ID</th>
            <th>AptName</th>
            <th>Address</th>
            <th>Representive Name</th>
            <th>PhoneNumber</th>
            <th>Email</th>
            <th>Crated at</th>
            <th>Action</th>
        </tr>
        <template v-if="aptLists && aptLists.length > 0">
            <tr v-for="(apt,i) in aptLists" :key="i">
                <td>{{i+1}}</td>
                <td>{{apt.aptName}}</td>
                <td>{{apt.address}}</td>
                <td>{{apt.repreName}}</td>
                <td>{{apt.phoneNumber}}</td>
                <td>{{apt.email}}</td>
                <td>{{TimeView(apt.created_at)}}</td>
                <td class="d-flex">
                    <Button type="info" size="small" @click="editApt(apt,i)">Edit</Button>
                    &nbsp;&nbsp;
                    <Button type="error" size="small" @click="delApt(apt,i)" :loading="isDeleting" :disabled="isDeleting">Delete</Button>
                    &nbsp;&nbsp;
                    <Button type="error" size="small" @click="registerSuperMng(apt)" :loading="isDeleting" :disabled="isDeleting">Register Super Manager</Button>
                    &nbsp;&nbsp;
                    <Button type="error" size="small" @click="registerBuilding(apt)" :loading="isDeleting" :disabled="isDeleting">Register Building</Button>
                </td>
            </tr>
        </template>
    </table>
    </div>
</template>

<script>
import {getAptLists,delApt} from '~/api/apartment'
export default {
    data(){
        return{
            aptLists:[],
            isAdding:false,
            isDeleting:false,
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
        addApt(){
            this.$router.push({path:'register'})
        },
        editApt(apt,index){
            this.$router.push({name:'apartment.details',params:{addData:apt}})
        },
        delApt(apt,index){
            this.isDeleting = true
            delApt(apt)
                .then(res=>{
                    this.success('successfully delted')
                    this.aptLists.splice(index,1)
                })
                .catch(err=>{
                    console.log(err)
                })
            this.isDeleting = false
        },
        registerSuperMng(apt){
            this.$router.push({name:'apartment.superManager',params:{aptData:apt}})
        },
        registerBuilding(apt){
            this.$router.push({name:'apartment.building',params:{aptData:apt}})
        }
    }
}
</script>

<style>

</style>