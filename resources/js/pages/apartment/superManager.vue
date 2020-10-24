<template>
    <div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">AptName</label>
            <div class="col-sm-10">
                {{aptData.aptName}}
            </div>
        </div>        
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">AptName</label>
            <div class="col-sm-10">
                {{aptData.address}}
            </div>
        </div>        
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">AptName</label>
            <div class="col-sm-10">
                {{aptData.repreName}}
            </div>
        </div>        
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">SuperManger</label>
            <div class="col-sm-10">
                <input type="text" id="aptName" v-model="superManager.mngName" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Phone Number</label>
            <div class="col-sm-10">
                <input type="text" id="aptName" v-model="superManager.mngPhoneNumber" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" id="aptName" v-model="superManager.mngEmail" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">SuperManger Id</label>
            <div class="col-sm-10">
                <input type="text" id="aptName" v-model="superManager.mngId" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">SuperMangerPWD</label>
            <div class="col-sm-10">
                <input type="text" id="aptName" v-model="superManager.mngPassword" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <Button type="success" @click="addSuperMng" :loading="isAdding" :disabled="isAdding">Register</Button>
        </div>
    </div>
</template>

<script>
import {addSuperMng} from '~/api/apartment'
export default {
    props:{
        aptData:Object
    },
    data(){
        return{
            superManager:{
                mngName:'',
                mngPhoneNumber:'',
                mngEmail:'',
                mngId:'',
                mngPassword:''    
            },
            isAdding:false,
        }
    },
    methods:{
        addSuperMng(){
            const object = {...this.aptData, ...this.superManager }
            console.log(object)
            this.isAdding = true
            addSuperMng(object)
                .then(res=>{
                    console.log(res)
                    this.$router.push({path:'/apartment'})
                })
                .catch(err=>{

                })
            this.isAdding = false
        }
    }
}
</script>

<style>

</style>