<template>
    <div class="container-fluid bg-light-gray m-0 p-0 pb-5">
        <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 pb-5 pt-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="p-3">New Request</h2>
                    <div class="d-flex align-items-center p-4">
                        <span class="mr-2">Select Mode:</span>
                        <i-switch @on-change="changeInputType" />
                    </div>
                </div>
                <Form :model="createRepairData">
                    <div class="row m-0 p-0">
                        <div v-if="autoInputMode" class="col-12 m-0 p-0 row">
                            <div class="col-12 col-md-6 mb-3 gray-input">
                                <Select v-model="createRepairData.type" size="large" style="width:100%" placeholder="please select repair type">
                                    <Option v-for="item in repairType" :value="item.value" :key="item.value">{{ item.label }}</Option>
                                </Select>
                            </div>
                            <div class="col-12 col-md-6 mb-3 gray-input">
                                <Select v-model="createRepairData.object" size="large" style="width:100%" placeholder="please select repair object">
                                    <Option v-for="item in repairObject" :value="item.value" :key="item.value">{{ item.label }}</Option>
                                </Select>
                            </div>
                            <div class="col-12 mb-3 newtopic gray-input">
                                <Select v-model="createRepairData.title" size="large" style="width:100%" placeholder="please select repair title">
                                    <Option v-for="item in repairTitle" :value="item.value" :key="item.value">{{ item.label }}</Option>
                                </Select>
                            </div>
                        </div>
                        <div v-else class="col-12 m-0 p-0 row">
                            <div class="col-12 col-md-6 mb-3 gray-input">
                                <Input v-model="createRepairData.type" placeholder="please enter type" />
                            </div>
                            <div class="col-12 col-md-6 mb-3 gray-input">
                                <Input v-model="createRepairData.object" placeholder="please enter object" />
                            </div>
                            <div class="col-12 mb-3 newtopic gray-input">
                                <Input v-model="createRepairData.title" placeholder="please enter title" />
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <wysiwyg v-model="createRepairData.desc" placeholder="please enter description" />
                        </div>
                        <div class="col-12 text-left d-flex justify-content-start mt-3 position-relative">
                            <Upload
                                @upImgUrl="upImgUrl"
                                @upFileUrl="upFileUrl"
                                @upVideoUrl="upVideoUrl"
                            />
                            <Icon @click="toggleEmo" class="pr-2 noti-upload-icons" size="25" type="md-happy" />
                            <div class="emoji-area-popup">
                                <Picker v-if="emoStatus" set="emojione" @select="onInput" title="Pick your emoji..." />
                            </div>
                            <Checkbox v-model="createRepairData.isShowToProprietor" label="Proprietor" class="ml-auto mr-2">
                                <Icon type="ios-person" size="25"/>
                                <span>Show to proprietor</span>
                            </Checkbox>
                            <Button icon="ios-briefcase-outline" type="warning" class="mr-2" @click="saveToDraftRequest" :disabled="isSavingDraft" :loading="isSavingDraft">Draft</Button>
                            <Button icon="ios-send" type="success" class="" @click="requestRepair" :disabled="isRequesting" :loading="isRequesting">Request</Button>
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
//import json
import repairType from '../../json/repairType';
import repairObject from '../../json/repairObject.json';
import repairTitle from '../../json/repairTitle.json';

export default {
    middleware: 'auth',

    components: {
        Picker,     //emoji
        Upload,
    },

    data(){
        return{
            autoInputMode: false,
            repairType,
            repairObject,
            repairTitle,
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

    methods:{
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
            if(this.createRepairData.type.trim() == ''){
                return this.error('Type is required')
            }
            if(this.createRepairData.object.trim() == ''){
                return this.error('Object is required')
            }
            if(this.createRepairData.title.trim() == ''){
                return this.error('Title is required')
            }
            if(this.createRepairData.desc.trim() == ''){
                return this.error('Description is required')
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

        async saveToDraftRequest(){
            this.emoStatus = false;
            if(this.createRepairData.type.trim() == ''){
                return this.error('Type is required')
            }
            if(this.createRepairData.object.trim() == ''){
                return this.error('Object is required')
            }
            if(this.createRepairData.title.trim() == ''){
                return this.error('Title is required')
            }
            if(this.createRepairData.desc.trim() == ''){
                return this.error('Description is required')
            }
            this.createRepairData.isDraft = 1;
            // this.isSavingDraft = true;
            // await registerSuggestion(this.createRepairData)
            // .then(res=>{
            //     this.createRepairData.title = '';
            //     this.createRepairData.desc = '';
            //     this.createRepairData.file.imgUrl = [];
            //     this.createRepairData.file.otherUrl = [];
            //     this.createRepairData.file.videoUrl = [];
            //     // this.$router.push({path:'/suggestion/index'})
                
            // })
            // .catch(err=>{
            //     console.log(err);
            // })
            // this.isSavingDraft = false
        },

        async deleteFile(type,fileName){
            let filePath = '';
            if(type == 'image'){
                filePath = fileName
            }else {
                filePath = fileName.imgUrl
            }

            let file = {fileName:filePath}

            await delUploadFile(file)
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
        }
    }
}
</script>