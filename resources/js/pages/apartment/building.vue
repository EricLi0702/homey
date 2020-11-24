<template>
    <div class="m-2 py-5 gray-input">
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">{{ $t('apartment').representativeName }}</label>
            <div class="col-sm-10">
                <input type="text" id="repreName" v-model="buildingInfo.number" class="form-control" :placeholder="$t('placeholder').enterDong">
            </div>
            <Button type="success" @click="addBuilding" :disabled="isAdding" :loading="isAdding">{{ $t('register').register }}</Button>
        </div>
        <table class="table">
            <tr>
                <th>{{ $t('apartment').buildingNumber }}</th>
                <th>{{ $t('apartment').display }}</th>
            </tr>
            <tr v-for="building in buildingList" :key="building.id">
                <td>{{building.number}}</td>
                <td>{{ $t('apartment').dong }}</td>
            </tr>
        </table> 
    </div>
</template>

<script> 
import {
    getBuildingList,
    addBuilding
} from '~/api/apartment'
export default {
    props:{
        aptData:Object
    },
    data(){
        return{
            buildingList:[],
            buildingInfo:{
                number:'',
            },
            isAdding:false,
        }
    },
    mounted(){
        getBuildingList(this.aptData.id)
            .then(res=>{
                this.buildingList = res.data
            })
            .catch(err=>{
                console.log(err)
            })
    },
    methods:{
        addBuilding(){
            this.isAdding = true
            this.$set(this.buildingInfo,'aptId',this.aptData.id)
            addBuilding(this.buildingInfo)
                .then(res=>{
                    this.buildingInfo.number = ''
                    this.buildingList.unshift(res.data)
                })
                .catch(err=>{
                    console.log(err)
                })
            this.isAdding = false
        }
    }
}
</script>
