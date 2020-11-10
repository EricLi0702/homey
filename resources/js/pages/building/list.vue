<template>
    <div>
        <table class="table">
            <tr>
                <th>{{ $t('apartment').buildingNumber }}</th>
                <th>{{ $t('apartment').display }}</th>
                <th>action</th>
            </tr>
            <tr v-for="building in buildingList" :key="building.id">
                <td>{{building.number}}</td>
                <td>{{ $t('apartment').dong }}</td>
                <td>
                    <Icon size="25" type="md-create" color="#44B4E2"/>
                    <Icon size="25" type="ios-trash" color="#FD0000" @click="openRemoveModal(building)"/>
                </td>
            </tr>
        </table> 
            <Modal v-model="removeModal" width="360">
                <p slot="header" style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span v-if="deleteBuildingData != null">Delete {{deleteBuildingData.number}}</span>
                </p>
                <div class="text-center">
                    <p>Will you delete it? All users and datas of this building will delete.</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long :loading="isDeletingBuilding" @click="delBuilding()">Delete</Button>
                </div>
            </Modal>
        <div class="form-group row">
            <label for="inputPassword" class="col-4 col-form-label">{{ $t('apartment').representativeName }}</label>
            <div class="col-8 gray-input">
                <input type="text" id="repreName" v-model="buildingInfo.number" class="form-control" placeholder="">
            </div>
            <Button class="m-3" long type="success" @click="addBuilding" :disabled="isAdding" :loading="isAdding">{{ $t('register').register }}</Button>
        </div>
    </div>
</template>

<script> 
import { mapGetters } from 'vuex'
import {getBuildingList,addBuilding,delBuilding} from '~/api/apartment'
export default {
    data(){
        return{
            buildingList:[],
            buildingInfo:{
                number:'',
                // type:''
            },
            isAdding:false,
            deleteBuildingData:null,
            removeModal:false,
            isDeletingBuilding:false,
        }
    },
    computed: mapGetters({
        currentUser: 'auth/user'
    }),
    mounted(){
        getBuildingList(this.currentUser.aptId)
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
            this.$set(this.buildingInfo,'aptId',this.currentUser.aptId)
            addBuilding(this.buildingInfo)
                .then(res=>{
                    this.buildingInfo.number = ''
                    this.buildingList.push(res.data)
                })
                .catch(err=>{
                    console.log(err)
                })
            this.isAdding = false
        },
        openRemoveModal(building){
            this.deleteBuildingData = building;
            this.removeModal = true;
            console.log("this.deleteBuildingData1", this.deleteBuildingData);
        },
        delBuilding(){
            this.isDeletingBuilding = true;
            console.log("this.deleteBuildingData2", this.deleteBuildingData);
            delBuilding(this.deleteBuildingData)
            .then(res=>{
                this.success("removed succesfully!");
                this.removeModal = false;
                this.isDeletingBuilding = false;
                this.buildingList.pop(this.deleteBuildingData);
                this.deleteBuildingData = null;
            })
            .catch(err=>{
                this.error("something went wrong!");
            })
            
        }
    }
}
</script>