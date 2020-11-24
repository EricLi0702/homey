<template>
    <div>
        <table class="table">
            <tr>
                <th>{{ $t('apartment').buildingNumber }}</th>
                <th>{{ $t('apartment').display }}</th>
                <th>{{ $t('apartment').action }}</th>
            </tr>
            <tr v-for="building in buildingList" :key="building.id">
                <td>{{building.number}}</td>
                <td>{{ $t('apartment').dong }}</td>
                <td>
                    <Icon size="25" type="md-create" color="#44B4E2" @click="openUpdateModal(building)"/>
                    <Icon size="25" type="ios-trash" color="#FD0000" @click="openRemoveModal(building)"/>
                </td>
            </tr>
        </table> 
            <Modal v-model="removeModal" width="360">
                <p slot="header" style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span v-if="deleteBuildingData != null">{{$t('apartment').delete}} : {{deleteBuildingData.number}}</span>
                </p>
                <div class="text-center">
                    <p>{{$t('modal').willDeleteBuilding}}</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long :loading="isDeletingBuilding" @click="delBuilding()">{{ $t('apartment').delete }}</Button>
                </div>
            </Modal>
            <Modal v-model="updateModal" width="360">
                <p slot="header" style="color:#47CB89;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span v-if="updateBuildingData != null">{{$t('auth').update}} : {{updateBuildingData.number}}</span>
                </p>
                <div class="text-center">
                    <Input v-if="updateBuildingData !== null" v-model="updateBuildingData.number" :placeholder="$t('placeholder').enterBuildingNumber" />
                </div>
                <div slot="footer">
                    <Button type="success" size="large" long :loading="isUpdatingBuilding" @click="updateBuilding()">{{ $t('notification').update }}</Button>
                </div>
            </Modal>
        <div class="form-group row">
            <label for="inputPassword" class="col-4 col-form-label">{{ $t('apartment').buildingNumber }}</label>
            <div class="col-8 gray-input">
                <input type="text" id="repreName" v-model="buildingInfo.number" class="form-control" :placeholder="$t('placeholder').enterBuildingNumber">
            </div>
            <Button class="m-3" type="success" @click="addBuilding" :disabled="isAdding" :loading="isAdding">{{ $t('register').register }}</Button>
        </div>
    </div>
</template>

<script> 
import { mapGetters } from 'vuex'
import i18n from '~/plugins/i18n'
import {getBuildingList,addBuilding,delBuilding, updateBuilding} from '~/api/apartment'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').building_manage }
    },
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
            updateBuildingData:null,
            updateModal:false,
            isUpdatingBuilding:false,
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
            if(this.buildingInfo.number.trim() == ''){
                return this.error(i18n.t('alert').dong);
            }
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
        },
        openUpdateModal(building){
            this.updateBuildingData = building;
            this.updateModal = true;
        },
        delBuilding(){
            this.isDeletingBuilding = true;
            delBuilding(this.deleteBuildingData)
            .then(res=>{
                this.success(i18n.t('alert').removeSuccessfully);
                this.removeModal = false;
                this.isDeletingBuilding = false;
                this.buildingList.pop(this.deleteBuildingData);
                this.deleteBuildingData = null;
            })
            .catch(err=>{
                this.error(i18n.t('alert').swr);
            })
            
        },

        updateBuilding(){
            this.isUpdatingBuilding = true;
            let payload = {
                id: this.updateBuildingData.id,
                number: this.updateBuildingData.number
            }
            updateBuilding(payload)
            .then(res=>{
                for(let i = 0; i<this.buildingList.length; i++){
                    if(this.buildingList[i].id == this.updateBuildingData.id){
                        this.buildingList[i].number = this.updateBuildingData.number;
                    }
                }
                this.updateBuildingData = null;
                this.isUpdatingBuilding = false;
                this.updateModal = false;
            })
            .catch(error=>{
                console.log(error.response);
            })
        }
    }
}
</script>