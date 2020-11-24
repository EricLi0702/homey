<template>
    <div class="container-fluid bg-light-gray m-0 p-0 pb-5">
        <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 pb-5 pt-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="p-3">{{$t('repair').NewRequest}}</h2>
                    <div class="d-flex align-items-center p-4">
                        <span class="mr-2">{{$t('repair').SelectMode}}</span>
                        <i-switch @on-change="changeInputType" />
                    </div>
                </div>
                <Form :model="createRepairData">
                    <div class="row m-0 p-0">
                        <div v-if="autoInputMode" class="col-12 m-0 p-0 row">
                            <div class="col-12 col-md-6 mb-3 gray-input">
                                <Select v-model="createRepairData.type" size="large" style="width:100%" @on-change="selectedRepairType(createRepairData.type)" :placeholder="$t('repair').selectRepairType">
                                    <Option v-for="item in repairJsonData" :value="item.value" :key="item.value">{{ item.label }}</Option>
                                </Select>
                            </div>
                            <div class="col-12 col-md-6 mb-3 gray-input">
                                <Select v-model="createRepairData.object" size="large" :disabled="willRepairObject == null" @on-change="selectedRepairObject(createRepairData.object)" style="width:100%" :placeholder="$t('repair').selectRepairObject">
                                    <Option v-for="item in willRepairObject" :value="item.value" :key="item.value">{{ item.label }}</Option>
                                </Select>
                            </div>
                            <div class="col-12 mb-3 newtopic gray-input">
                                <Select v-model="createRepairData.title" size="large" :disabled="willRepairTitle == null" @on-change="selectedRepairTitle(createRepairData.title)" style="width:100%" :placeholder="$t('repair').selectRepairTitle">
                                    <Option v-for="item in willRepairTitle" :value="item.value" :key="item.value">{{ item.label }}</Option>
                                </Select>
                            </div>
                        </div>
                        <div v-else class="col-12 m-0 p-0 row">
                            <div class="col-12 col-md-6 mb-3 gray-input">
                                <Input v-model="createRepairData.type" :placeholder="$t('repair').enterType" />
                            </div>
                            <div class="col-12 col-md-6 mb-3 gray-input">
                                <Input v-model="createRepairData.object" :placeholder="$t('repair').enterObject" />
                            </div>
                            <div class="col-12 mb-3 newtopic gray-input">
                                <Input v-model="createRepairData.title" :placeholder="$t('placeholder').enterTitle" />
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <wysiwyg v-model="createRepairData.desc" :placeholder="$t('placeholder').enterDescription" />
                        </div>
                        <div class="col-12 text-left d-flex justify-content-start mt-3 position-relative">
                            <Upload
                                @upImgUrl="upImgUrl"
                                @upFileUrl="upFileUrl"
                                @upVideoUrl="upVideoUrl"
                            />
                            <Icon @click="toggleEmo" class="pr-2 noti-upload-icons" size="25" type="md-happy" />
                            <div class="emoji-area-popup">
                                <div v-if="emoStatus" class="position-absolute close-emoji-btn" @click="closeEmojiWindow()">{{$t('common').closeEmoji}}</div>
                                <Picker v-if="emoStatus" set="emojione" @select="onInput" title="Pick your emoji..." />
                            </div>
                            <Checkbox v-model="createRepairData.isShowToProprietor" label="Proprietor" class="ml-auto mr-2">
                                <Icon type="ios-person" size="25"/>
                                <span>{{$t('repair').ShowProprietor}}</span>
                            </Checkbox>
                            <Button icon="ios-send" type="success" class="" @click="requestRepair" :disabled="isRequesting" :loading="isRequesting">{{$t('repair').Request}}</Button>
                        </div>
                        <div class="col-12 uploaded_file">
                            <div class="image-item" v-if="createRepairData.file.imgUrl && createRepairData.file.imgUrl.length >0">
                                <div class="image-block">
                                    <div class="image-upload-list" v-for="(imgUrl,i) in createRepairData.file.imgUrl" :key="i">
                                        <img :src="imgUrl" alt="">
                                        <div class="demo-upload-list-cover">
                                            <Icon  type="ios-trash-outline" @click="deleteFile('image',imgUrl)"></Icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="file-item row" v-if="createRepairData.file.otherUrl.length &&createRepairData.file.otherUrl.length>0">
                                <div class="col-6 col-md-4" v-for="(otherUrl,j) in createRepairData.file.otherUrl" :key="j">
                                    <div class="image-upload-list float-left">
                                        <img src="/asset/img/icon/upload_file_img.png" class="w-100" alt="">
                                        <div class="demo-upload-list-cover">
                                            <Icon type="ios-trash-outline" @click="deleteFile('other',otherUrl)"></Icon>
                                        </div>
                                    </div>
                                    <div class="title pt-2">
                                        <div class="text-break">{{otherUrl.fileOriName}}</div>
                                        <div class="text-secondary">{{otherUrl.fileSize}}</div>
                                    </div>
                                    <div class="remark"></div>
                                </div>
                            </div>
                            <div class="file-item row" v-if="createRepairData.file.videoUrl.length && createRepairData.file.videoUrl.length>0">
                                <div class="col-6 col-md-4" v-for="(videoUrl,j) in createRepairData.file.videoUrl" :key="j">
                                    <div class="image-upload-list float-left">
                                        <img src="/asset/img/icon/upload_video_img.png" class="w-100" alt="">
                                        <div class="demo-upload-list-cover">
                                            <Icon type="ios-trash-outline" @click="deleteFile('video',videoUrl)"></Icon>
                                        </div>
                                    </div>
                                    <div class="title pt-2">
                                        <div class="text-break">{{videoUrl.fileOriName}}</div>
                                        <div class="text-secondary">{{videoUrl.fileSize}}</div>
                                    </div>
                                </div>
                                <div class="remark"></div>
                            </div>
                        </div>
                    </div>
                </Form> 
            </div>
        </div>
    </div>
</template>

<script>
//textArea
import wysiwyg from "vue-wysiwyg"
//emoji
import { Picker } from 'emoji-mart-vue'
//file upload component
import Upload from '~/components/Upload'
//import Api
import {registerRepair} from '~/api/repair'
import {delUploadFile} from '~/api/upload'

import {getRepairJsonData} from '../../api/repair'
import { mapGetters } from 'vuex'
import i18n from '~/plugins/i18n'

export default {
    metaInfo () {
        return { title: this.$t('metaInfo').newRepairRequest }
    },
    middleware: 'auth',

    components: {
        Picker,     //emoji
        Upload,
    },

    computed:{ 
        ...mapGetters({
            currentUser: 'auth/user',
            currentLang:'lang/locale'
        }),
    },

    watch:{
        currentLang:{
            handler(val){
                if(val == 'en'){
                    this.repairJsonData = this.enJsonData;
                    this.willRepairObject = null;
                    this.willRepairTitle = null;
                }
                if(val == 'kr'){
                    this.repairJsonData = this.krJsonData;
                    this.willRepairObject = null;
                    this.willRepairTitle = null;
                }
                if(val == 'vn'){
                    this.repairJsonData = this.vnJsonData;
                    this.willRepairObject = null;
                    this.willRepairTitle = null;
                }
            },
            deep:true
        }
    },

    data(){
        return{
            repairJsonData:null,
            enJsonData:[],
            krJsonData:[],
            vnJsonData:[],
            willRepairObject:null,
            willRepairTitle:null,
            autoInputMode: false,
            createRepairData: {
                title: '',
                desc: '',
                type:'',
                object:'',
                file:{
                    imgUrl:[],
                    otherUrl:[],
                    videoUrl:[]
                },
                isDraft:null,
                isShowToProprietor:false,
            },

            //emoji
            emoStatus:false,

            isRequesting:false,
            isSavingDraft:false,
        }
    },

    created(){
        getRepairJsonData()
        .then(res=>{
            this.enJsonData = JSON.parse(res.data[0].repair_type);
            this.krJsonData = JSON.parse(res.data[1].repair_type);
            this.vnJsonData = JSON.parse(res.data[2].repair_type);
            if(this.currentLang == 'en'){
                this.repairJsonData = this.enJsonData;
            }
            if(this.currentLang == 'kr'){
                this.repairJsonData = this.krJsonData;
            }
            if(this.currentLang == 'vn'){
                this.repairJsonData = this.vnJsonData;
            }
        })
        .catch(err=>{
            console.log(err.response)
        })
    },

    methods:{
        closeEmojiWindow(){
            this.emoStatus = false;
        },
        
        toggleEmo(){
            this.emoStatus = !this.emoStatus;
        },
        onInput(e){
            if(!e){
                return false;
            }
            if(!this.createRepairData.desc){
                this.createRepairData.desc = e.native
            }else{
                this.createRepairData.desc = this.createRepairData.desc + e.native
            }
        },

        async requestRepair(){
            this.emoStatus = false;
            if(this.autoInputMode){
                if(this.createRepairData.type == ''){
                    return this.error(i18n.t('alert').type);
                }
                if(this.createRepairData.object == ''){
                    return this.error(i18n.t('alert').object);
                }
                if(this.createRepairData.title == ''){
                    return this.error(i18n.t('alert').title);
                }
                if(this.createRepairData.desc.trim() == ''){
                    return this.error(i18n.t('alert').desc);
                }
            }
            else{
                if(this.createRepairData.type.trim() == ''){
                    return this.error(i18n.t('alert').type);
                }
                if(this.createRepairData.object.trim() == ''){
                    return this.error(i18n.t('alert').object);
                }
                if(this.createRepairData.title.trim() == ''){
                    return this.error(i18n.t('alert').title);
                }
                if(this.createRepairData.desc.trim() == ''){
                    return this.error(i18n.t('alert').desc);
                }
            }   
            this.isRequesting = true;
            await registerRepair(this.createRepairData)
            .then(res=>{
                this.createRepairData.title = '';
                this.createRepairData.desc = '';
                this.createRepairData.type = '';
                this.createRepairData.object = '';
                this.createRepairData.isDraft = null;
                this.createRepairData.isShowToProprietor = false;
                this.createRepairData.file.imgUrl = [];
                this.createRepairData.file.otherUrl = [];
                this.createRepairData.file.videoUrl = [];
                this.$router.push({path:'/repair/index'})
                
            })
            .catch(err=>{
                console.log(err);
            })
            this.isRequesting = false;
        },

        async deleteFile(type,fileName){
            let filePath = '';
            if(type == 'image'){
                filePath = fileName
            }else {
                filePath = fileName.imgUrl
            }

            

            await delUploadFile(filePath)
            .then(res=>{
                    if(type == 'image'){
                        this.createRepairData.file.imgUrl.pop(fileName)
                    }else if(type == 'other'){
                        this.createRepairData.file.otherUrl.pop(fileName)
                    }else if(type == 'video'){
                        this.createRepairData.file.videoUrl.pop(fileName)
                    }
                })
            .catch(err=>{
                console.log(err);
            })
        },

        //listen event from Upload
        upImgUrl(value) {
            this.createRepairData.file.imgUrl.push(value);
        },
        upFileUrl(value) {
            this.createRepairData.file.otherUrl.push(value);
        },
        upVideoUrl(value) {
            this.createRepairData.file.videoUrl.push(value);
        },
        changeInputType(){
            if(this.autoInputMode == false){
                this.autoInputMode = true;
            }
            else{
                this.autoInputMode = false;
            }
            this.createRepairData.title = '';
            this.createRepairData.type = '';
            this.createRepairData.object = '';
        },

        selectedRepairType(val){
            this.willRepairObject = this.repairJsonData[val-1].object;
            this.createRepairData.title = '';
            this.willRepairTitle = null;
            this.createRepairData.object = '';
        },
        selectedRepairObject(val){
            if (val != undefined){
                this.willRepairTitle = this.willRepairObject[val-1].title;
            }
        },
        selectedRepairTitle(val){

        }
    }
}
</script>