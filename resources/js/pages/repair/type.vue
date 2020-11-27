<template>
    <div class="container-fluid bg-light-gray m-0 p-0 pb-5">
        <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 pt-2 d-flex align-items-center justify-content-between">
                <h2 class="p-3">{{$t('repair').repairType}}</h2>
                <div class="sel-lang-repair">
                    <Select v-model="selectedLang" default-label="VN" style="width:100px" @on-change="selectLang(selectedLang)">
                        <img class="navbar-flag" :src="`/asset/img/icon/${selectedLang}_flag.png`" slot="prefix"  alt="" />
                        <Option v-for="item in language" :value="item.value" :key="item.value">{{ item.label }}</Option>
                    </Select>
                </div>
            </div>

            <div class="add-repair-type-btn d-flex justify-content-end p-3">
                <Button type="primary" @click="saveToJson()" :disabled="isUpdatingRepairJson" :loading="isUpdatingRepairJson" class="mr-3">{{$t('repair').saveRepariType}}</Button>
                <Button type="info" @click="addType()">{{$t('repair').newRepariType}}</Button>
            </div>

            <div class="str-table-area p-3">
                <div v-for="(type,i) in repairJsonData" :key="i">
                    <div class="d-flex align-items-center justify-content-center mt-4">
                        <div class="d-flex align-items-center py-2 px-4 rounded progress-bar progress-bar-striped progress-bar-animated flex-row">
                            <h5 class="mr-3">{{type.label}}</h5>
                            <Icon size="25" type="md-add" color="#FF9900" @click="addObject(type,i)"/>
                            <Icon size="25" type="md-create" color="#44B4E2" @click="editType(type,i)"/>
                            <Icon size="25" type="ios-trash" color="#FD0000" @click="removeType(type,i)"/>
                        </div>
                    </div>
                    <div v-for="(object, j) in type.object" :key="j">
                        <div class="d-flex align-items-center justify-content-start py-2 px-4 rounded border mt-2">
                            {{object.label}}
                            <Icon size="25" type="md-add" color="#FF9900" @click="addTitle(type, object, j)"/>
                            <Icon size="25" type="md-create" color="#44B4E2" @click="editObject(type, object, j)"/>
                            <Icon size="25" type="ios-trash" color="#FD0000" @click="removeObject(type, object, j)"/>
                        </div>
                        <div v-for="(title, k) in object.title" :key="k" class="border text-center">
                            <div class="d-flex align-items-center justify-content-center py-2 px-4 rounded border">
                                {{title.label}}
                                <Icon size="25" type="md-create" color="#44B4E2" @click="editTitle(type, object, title, k)"/>
                                <Icon size="25" type="ios-trash" color="#FD0000" @click="removeTitle(type, object, title, k)"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Modal v-model="isEditRepairModal" width="360" @on-cancel="initVal()">
                <p slot="header" style="color:#21C070;text-align:center" class="d-flex align-items-center justify-content-center">
                    <Icon class="mr-3" type="ios-create-outline" size="25"/>
                    <span v-if="editRepairTypeData !== null && editRepairObjectData == null">{{$t('modal').updateRepairType}}</span>
                    <span v-else-if="editRepairTypeData != null && editRepairObjectData !== null && editRepairTitleData == null">{{$t('modal').updateRepairObject}}</span>
                    <span v-else-if="editRepairTitleData != null">{{$t('modal').updateRepairTitle}}</span>
                </p>
                <div class="text-center gray-input">
                    <Input v-if="editRepairTypeData !== null && editRepairObjectData == null" v-model="editRepairTypeData.label" :placeholder="$t('repair').enterType" />
                    <Input v-else-if="editRepairTypeData != null && editRepairObjectData !== null && editRepairTitleData == null" v-model="editRepairObjectData.label" :placeholder="$t('repair').enterObject"/>
                    <Input v-else-if="editRepairTitleData != null" v-model="editRepairTitleData.label" :placeholder="$t('placeholder').enterTitle" />
                </div>
                <div slot="footer">
                    <Button type="success" size="large" long @click="updateRepairContent()">{{$t('auth').update}}</Button>
                </div>
            </Modal>
            <Modal v-model="isDeleteRepairModal" width="360" @on-cancel="initVal()">
                <p slot="header" style="color:#f60;text-align:center" class="d-flex align-items-center justify-content-center">
                    <Icon class="mr-3" type="md-warning" size="25" color="#ED4014"/>
                    <span v-if="deleteRepairTypeData !== null && deleteRepairObjectData == null">{{$t('modal').deleteRepairType}}</span>
                    <span v-else-if="deleteRepairTypeData != null && deleteRepairObjectData !== null && deleteRepairTitleData == null">{{$t('modal').deleteRepairObject}}</span>
                    <span v-else-if="deleteRepairTitleData != null">{{$t('modal').deleteRepairTitle}}</span>
                </p>
                <div class="text-center gray-input">
                    <p v-if="deleteRepairTypeData !== null && deleteRepairObjectData == null" > {{$t('modal').areYouSureDelRepairType}} : {{deleteRepairTypeData.label}}</p>
                    <p v-else-if="deleteRepairTypeData != null && deleteRepairObjectData !== null && deleteRepairTitleData == null">{{$t('modal').areYouSureDelRepairObject}} : {{deleteRepairObjectData.label}}</p> 
                    <p v-else-if="deleteRepairTitleData != null">{{$t('modal').areYouSureDelRepairTitle}} : {{deleteRepairTitleData.label}}</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long @click="deleteRepairContent()">{{$t('apartment').delete}}</Button>
                </div>
            </Modal>
            <Modal v-model="isAddRepairModal" width="360" @on-cancel="initVal()">
                <p slot="header" style="color:#2D8CF0;text-align:center" class="d-flex align-items-center justify-content-center">
                    <Icon class="mr-3" type="md-create" size="25"/>
                    <span v-if="addRepairTypeData == null && addRepairObjectData == null">{{$t('modal').addRepairType}}</span>
                    <span v-else-if="addRepairTypeData != null && addRepairObjectData == null">{{$t('modal').addRepairObject}}</span>
                    <span v-else-if="addRepairTypeData != null && addRepairObjectData !== null">{{$t('modal').addRepairTitle}}</span>
                </p>
                <div class="text-center gray-input">
                    <Input v-if="addRepairTypeData == null && addRepairObjectData == null" v-model="addInputRepairTypeData" :placeholder="$t('repair').enterType"/>
                    <Input v-else-if="addRepairTypeData != null && addRepairObjectData == null" v-model="addInputRepairObjectData" :placeholder="$t('repair').enterObject"/>
                    <Input v-else-if="addRepairTypeData != null && addRepairObjectData !== null" v-model="addInputRepairTitleData" :placeholder="$t('placeholder').enterTitle" />
                </div>
                <div slot="footer">
                    <Button type="success" size="large" long @click="addRepairContent()">{{$t('modal').add}}</Button>
                </div>
            </Modal>
        </div>
    </div>
</template>

<script>
import {getRepairJsonData, saveToJson} from '../../api/repair'
import i18n from '~/plugins/i18n'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').registerRepairType }
    },
    middleware: 'repairmanager',

    components: {
        
    },

    created(){
        getRepairJsonData()
        .then(res=>{
            this.enJsonData = JSON.parse(res.data[0].repair_type);
            this.krJsonData = JSON.parse(res.data[1].repair_type);
            this.vnJsonData = JSON.parse(res.data[2].repair_type);
            this.repairJsonData = this.vnJsonData;
        })
        .catch(err=>{
            console.log(err.response)
        })
    },

    data(){
        return{
            enJsonData:[],
            krJsonData:[],
            vnJsonData:[],
            repairJsonData:[],
            language:[
                {
                    value:"VN",
                    label:"VN"
                },
                {
                    value:"EN",
                    label:"EN"
                },
                {
                    value:"KR",
                    label:"KR"
                }
            ],
            selectedLang:"VN",
            //edit variable group
            editRepairTypeData: null,
            editRepairTypeIndex: null,
            editRepairObjectData: null,
            editRepairObjectIndex: null,
            editRepairTitleData: null,
            editRepairTitleIndex: null,
            //delete variable group
            deleteRepairTypeData: null,
            deleteRepairTypeIndex: null,
            deleteRepairObjectData: null,
            deleteRepairObjectIndex: null,
            deleteRepairTitleData: null,
            deleteRepairTitleIndex: null,
            //delete variable group
            addRepairTypeData: null,
            addRepairTypeIndex: null,
            addRepairObjectData: null,
            addRepairObjectIndex: null,
            addRepairTitleData: null,
            addRepairTitleIndex: null,
            addInputRepairTypeData:'',
            addInputRepairObjectData:'',
            addInputRepairTitleData:'',
            //edit & update modal
            isEditRepairModal:false,
            isDeleteRepairModal:false,
            isAddRepairModal:false,
            isUpdatingRepairJson:false,

        }
    },

    methods:{
        selectLang(selLang){
            if(selLang == "VN"){
                this.repairJsonData = this.vnJsonData;
            }
            if(selLang == "EN"){
                this.repairJsonData = this.enJsonData;
            }
            if(selLang == "KR"){
                this.repairJsonData = this.krJsonData;
            }
        },

        addType(){
            this.isAddRepairModal = true;
        },

        editType(type, index){
            this.editRepairTypeData = type;
            this.editRepairTypeIndex = index;
            this.isEditRepairModal = true;
        },

        removeType(type, index){
            this.deleteRepairTypeData = type;
            this.deleteRepairTypeIndex = index;
            this.isDeleteRepairModal = true;
        },

        addObject(type, index){
            this.addRepairTypeData = type;
            this.addRepairTypeIndex = index;
            this.isAddRepairModal = true;
        },

        editObject(type, object, index){
            this.editRepairTypeData = type;
            this.editRepairObjectData = object;
            this.editRepairObjectIndex = index;
            this.isEditRepairModal = true;
        },

        removeObject(type, object, index){
            this.deleteRepairTypeData = type;
            this.deleteRepairObjectData = object;
            this.deleteRepairObjectIndex = index;
            this.isDeleteRepairModal = true;
        },

        addTitle(type, object, index){
            this.addRepairTypeData = type;
            this.addRepairObjectData = object;
            this.addRepairObjectIndex = index;
            this.isAddRepairModal = true;
        },

        editTitle(type, object, title, index){
            this.editRepairTypeData = type;
            this.editRepairObjectData = object;
            this.editRepairTitleData = title;
            this.editRepairTitleIndex = index;
            this.isEditRepairModal = true;
        },

        removeTitle(type, object, title, index){
            this.deleteRepairTypeData = type;
            this.deleteRepairObjectData = object;
            this.deleteRepairTitleData = title;
            this.deleteRepairTitleIndex = index;
            this.isDeleteRepairModal = true;
        },

        initVal(){
            this.editRepairTypeData = null;
            this.editRepairTypeIndex = null;
            this.editRepairObjectData = null;
            this.editRepairObjectIndex = null;
            this.editRepairTitleData = null;
            this.editRepairTitleIndex = null;
            this.deleteRepairTypeData = null;
            this.deleteRepairTypeIndex = null;
            this.deleteRepairObjectData = null;
            this.deleteRepairObjectIndex = null;
            this.deleteRepairTitleData = null;
            this.deleteRepairTitleIndex = null;
            this.addRepairTypeData = null;
            this.addRepairTypeIndex = null;
            this.addRepairObjectData = null;
            this.addRepairObjectIndex = null;
            this.addRepairTitleData = null;
            this.addRepairTitleIndex = null;
            this.addInputRepairTypeData = '';
            this.addInputRepairObjectData = '';
            this.addInputRepairTitleData = '';
        },

        deleteRepairContent(){
            //delete repair type
            if(this.deleteRepairTypeData !== null && this.deleteRepairObjectData == null){
                this.repairJsonData.splice(this.deleteRepairTypeIndex, 1);
                for(let i = this.deleteRepairTypeIndex; i < this.repairJsonData[i] ; i++){
                    this.repairJsonData[i].value = parseInt(this.repairJsonData[i].value) - 1;
                }
                this.deleteRepairTypeData = null;
                this.deleteRepairTypeIndex = null;
                this.isDeleteRepairModal = false;
            }

            //delete repair object
            if(this.deleteRepairTypeData != null && this.deleteRepairObjectData !== null && this.deleteRepairTitleData == null){
                this.repairJsonData[this.deleteRepairTypeData.value-1].object.splice(this.deleteRepairObjectIndex, 1);
                for(let i = this.deleteRepairObjectIndex ; i < this.repairJsonData[this.deleteRepairTypeData.value-1].object.length ; i++){
                    this.repairJsonData[this.deleteRepairTypeData.value-1].object[i].value = parseInt(this.repairJsonData[this.deleteRepairTypeData.value-1].object[i].value) - 1;
                }
                this.deleteRepairTypeData = null;
                this.deleteRepairObjectData = null;
                this.deleteRepairObjectIndex = null;
                this.isDeleteRepairModal = false;
            }

            //delete repair title
            if(this.deleteRepairTitleData != null){
                this.repairJsonData[this.deleteRepairTypeData.value-1].object[this.deleteRepairObjectData.value-1].title.splice(this.deleteRepairTitleIndex, 1);
                for(let i = this.deleteRepairTitleIndex; i < this.repairJsonData[this.deleteRepairTypeData.value-1].object[this.deleteRepairObjectData.value-1].title.length ; i++){
                    this.repairJsonData[this.deleteRepairTypeData.value-1].object[this.deleteRepairObjectData.value-1].title[i].value = parseInt(this.repairJsonData[this.deleteRepairTypeData.value-1].object[this.deleteRepairObjectData.value-1].title[i].value) - 1
                }
                this.deleteRepairTypeData = null;
                this.deleteRepairObjectData = null;
                this.deleteRepairTitleData = null;
                this.deleteRepairTitleIndex = null;
                this.isDeleteRepairModal = false;
            }
        },

        updateRepairContent(){
            //edit repair type
            if(this.editRepairTypeData !== null && this.editRepairObjectData == null){
                this.repairJsonData[this.editRepairTypeIndex].label = this.editRepairTypeData.label;
                this.editRepairTypeData = null;
                this.editRepairTypeIndex = null;
                this.isEditRepairModal = false;
            }

            //edit repair object
            if(this.editRepairTypeData != null && this.editRepairObjectData !== null && this.editRepairTitleData == null){
                this.repairJsonData[this.editRepairTypeData.value-1].object[this.editRepairObjectIndex].label = this.editRepairObjectData.label;
                this.editRepairTypeData = null;
                this.editRepairObjectData = null;
                this.editRepairObjectIndex = null;
                this.isEditRepairModal = false;
            }

            //edit repair title
            if(this.editRepairTitleData != null){
                this.repairJsonData[this.editRepairTypeData.value-1].object[this.editRepairObjectData.value-1].title[this.editRepairTitleIndex].label = this.editRepairTitleData.label;
                this.editRepairTypeData = null;
                this.editRepairObjectData = null;
                this.editRepairTitleData = null;
                this.editRepairTitleIndex = null;
                this.isEditRepairModal = false;
            }
        },

        addRepairContent(){
            //add repair type
            if(this.addRepairTypeData == null && this.addRepairObjectData == null){
                this.addRepairTypeData = {
                    value: this.repairJsonData.length + 1,
                    label: this.addInputRepairTypeData,
                    object:[]
                }
                this.repairJsonData.push(this.addRepairTypeData);
                this.isAddRepairModal = false;
                this.addRepairTypeData = null;
                this.addInputRepairTypeData = '';
            }

            //add repair object
            if(this.addRepairTypeData != null && this.addRepairObjectData == null){
                this.addRepairObjectData = {
                    value: this.addRepairTypeData.object.length + 1,
                    label: this.addInputRepairObjectData,
                    title:[]
                }
                this.repairJsonData[this.addRepairTypeData.value-1].object.push(this.addRepairObjectData);
                this.addRepairTypeData = null;
                this.addRepairTypeIndex = null;
                this.addRepairObjectData = null;
                this.addInputRepairObjectData = '';
                this.isAddRepairModal = false;
            }

            //add repair title
            if(this.addRepairTypeData != null && this.addRepairObjectData !== null){
                this.addRepairTitleData = {
                    value: this.addRepairObjectData.title.length + 1,
                    label: this.addInputRepairTitleData,
                }
                this.repairJsonData[this.addRepairTypeData.value-1].object[this.addRepairObjectData.value-1].title.push(this.addRepairTitleData);
                this.addRepairTypeData = null;
                this.addRepairObjectData = null;
                this.addRepairObjectIndex = null;
                this.addInputRepairTitleData = '';
                this.isAddRepairModal = false;
            }
        },

        saveToJson(){
            console.log("****************", this.repairJsonData);
            // this.isUpdatingRepairJson = true;
            // let payload = {
            //     lang : this.selectedLang,
            //     jsonData : this.repairJsonData
            // }
            // saveToJson(payload)
            // .then(res=>{
            //     this.success(i18n.t('alert').update);
            //     this.isUpdatingRepairJson = false;
            // })
            // .catch(err=>{
            //     console.log(err.response);
            // })
        }

    }
}
</script>