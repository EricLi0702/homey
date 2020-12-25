<template>
    <div class="m-2 py-5 gray-input">
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">{{ $t('apartment').AptName }}</label>
            <div class="col-sm-10">
                {{aptData.aptName}}
            </div>
        </div>        
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">{{ $t('apartment').address }}</label>
            <div class="col-sm-10">
                {{aptData.address}}
            </div>
        </div>        
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">{{ $t('apartment').representName }}</label>
            <div class="col-sm-10">
                {{aptData.repreName}}
            </div>
        </div>        
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">{{ $t('apartment').superManger }}</label>
            <div class="col-sm-10">
                <input type="text" id="aptName" v-model="superManager.mngName" class="form-control" :placeholder="$t('placeholder').enterSuperManagerName">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">{{ $t('apartment').phoneNumber }}</label>
            <div class="col-sm-10">
                <input type="text" id="aptName" v-model="superManager.mngPhoneNumber" class="form-control" :placeholder="$t('placeholder').enterSuperManagerPhone">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">{{ $t('apartment').eMail }}</label>
            <div class="col-sm-10">
                <input type="email" id="aptName" v-model="superManager.mngEmail" class="form-control" :placeholder="$t('placeholder').enterSuperManagerEmail">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">{{ $t('apartment').superMangerId }}</label>
            <div class="col-sm-10">
                <input type="text" id="aptName" v-model="superManager.mngId" class="form-control" :placeholder="$t('placeholder').enterSuperManagerId">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">{{ $t('apartment').superMangerPWD }}</label>
            <div class="col-sm-10">
                <input type="text" id="aptName" v-model="superManager.mngPassword" class="form-control" :placeholder="$t('placeholder').enterSuperManagerPassword">
            </div>
        </div>
        <div class="form-group row">
            <Button type="success" @click="addSuperMng" :loading="isAdding" :disabled="isAdding">{{ $t('register').register }}</Button>
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
            this.isAdding = true
            addSuperMng(object)
                .then(res=>{
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