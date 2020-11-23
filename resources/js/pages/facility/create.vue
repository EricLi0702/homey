<template>
    <div class="container-fluid bg-light-gray m-0 p-0 pb-5">
        <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 pb-5 pt-2">
                <h2 class="p-3">{{ $t('facility').NewFacility }}</h2>
                <Form :model="createFacilityData">
                    <div class="row m-0 p-0">
                        <div class="col-12 mb-3 gray-input fac-name">
                            <Input v-model="createFacilityData.name" :placeholder="$t('facility').enterName" />
                        </div>
                        <div class="col-12 mb-3 gray-input fac-equipment">
                            <Input v-model="createFacilityData.equipment" :placeholder="$t('facility').enterEquipments" />
                        </div>
                        <div class="col-12 mb-3 gray-input fac-nb">
                            <Input v-model="createFacilityData.nb" :placeholder="$t('facility').enterNB" />
                        </div>
                        <div class="col-12 mb-3 gray-input fac-max d-flex align-items-center">
                            <Icon class="mr-2" size="25" type="ios-people" />
                            <InputNumber :max="100" :min="1" v-model="createFacilityData.max"></InputNumber>
                            <p class="text-secondary ml-4">({{$t('facility').MaxNumberPeople}})</p>
                        </div>
                        <div class="col-12 mb-3">
                            <wysiwyg v-model="createFacilityData.outline" :placeholder="$t('facility').enterOutline" />
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
                            <Button icon="md-create" type="success" class="ml-auto" @click="registerNewFacility" :disabled="isCreatingNewFacility" :loading="isCreatingNewFacility">Create{{ $t('facility').reply }}</Button>
                        </div>
                        <div class="col-12 uploaded_file">
                            <div class="image-item" v-if="createFacilityData.file.imgUrl && createFacilityData.file.imgUrl.length >0">
                                <div class="image-block">
                                    <div class="image-upload-list" v-for="(imgUrl,i) in createFacilityData.file.imgUrl" :key="i">
                                        <img :src="imgUrl" alt="">
                                        <div class="demo-upload-list-cover">
                                            <Icon  type="ios-trash-outline" @click="deleteFile('image',imgUrl)"></Icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="file-item row" v-if="createFacilityData.file.otherUrl.length &&createFacilityData.file.otherUrl.length>0">
                                <div class="col-6 col-md-4" v-for="(otherUrl,j) in createFacilityData.file.otherUrl" :key="j">
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
                            <div class="file-item row" v-if="createFacilityData.file.videoUrl.length && createFacilityData.file.videoUrl.length>0">
                                <div class="col-6 col-md-4" v-for="(videoUrl,j) in createFacilityData.file.videoUrl" :key="j">
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
import {registerFacility} from '~/api/facility'
import {delUploadFile} from '~/api/upload'
import i18n from '~/plugins/i18n'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').FacilityCreate }
    },
    middleware: 'manager',

    components: {
        Picker,     //emoji
        Upload,
    },

    data(){
        return{
            createFacilityData: {
                name: '',
                max: 1,
                equipment:'',
                outline:'',
                nb:'',
                file:{
                    imgUrl:[],
                    otherUrl:[],
                    videoUrl:[]
                },
            },
            //emoji
            emoStatus:false,

            initPeriod:'forever',
            periodType:'withPeriod',
            isCreatingNewFacility:false,
            isSavingDraft:false,
        }
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
            if(!this.createFacilityData.outline){
                this.createFacilityData.outline = e.native
            }else{
                this.createFacilityData.outline = this.createFacilityData.outline + e.native
            }
        },

        async registerNewFacility(){
            this.emoStatus = false;
            if(this.createFacilityData.name.trim() == ''){
                return this.error(i18n.t('alert').name);
            }
            if(this.createFacilityData.equipment.trim() == ''){
                return this.error(i18n.t('alert').equipment);
            }
            if(this.createFacilityData.nb.trim() == ''){
                return this.error(i18n.t('alert').nb);
            }
            if(this.createFacilityData.outline.trim() == ''){
                return this.error(i18n.t('alert').outline);
            }
            if(this.createFacilityData.file.imgUrl.length == 0){
                return this.error(i18n.t('alert').morethanOneImage);
            }

            this.isCreatingNewFacility = true;
            await registerFacility(this.createFacilityData)
            .then(res=>{
                this.createFacilityData.name = '';
                this.createFacilityData.equipment = '';
                this.createFacilityData.outline = '';
                this.createFacilityData.nb = '';
                this.createFacilityData.max = 1;
                this.createFacilityData.file.imgUrl = [];
                this.createFacilityData.file.otherUrl = [];
                this.createFacilityData.file.videoUrl = [];
                this.$router.push({path:'/facility/index'})
                
            })
            .catch(err=>{
                console.log(err);
            })
            this.isCreatingNewFacility = false
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
                        this.createFacilityData.file.imgUrl.pop(fileName)
                    }else if(type == 'other'){
                        this.createFacilityData.file.otherUrl.pop(fileName)
                    }else if(type == 'video'){
                        this.createFacilityData.file.videoUrl.pop(fileName)
                    }
                })
            .catch(err=>{
                console.log(err);
            })
        },

        //listen event from Upload
        upImgUrl(value) {
            this.createFacilityData.file.imgUrl.push(value);
        },
        upFileUrl(value) {
            this.createFacilityData.file.otherUrl.push(value);
        },
        upVideoUrl(value) {
            this.createFacilityData.file.videoUrl.push(value);
        },

    }
}
</script>