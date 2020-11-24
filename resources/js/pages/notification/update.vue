<template>
    <div class="container-fluid bg-light-gray m-0 p-0 pb-5">
        <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 pb-5 pt-2">
                <h2 class="p-3">{{$t('welcome').UpdateNotification}}</h2>
                <Form :model="updateNotificationData" v-if=" updateNotificationData !== null">
                    <div class="row m-0 p-0">
                        <div class="col-md-6 mb-3 gray-input">
                            <p>{{$t('notification').title}}</p>
                            <Input v-model="updateNotificationData.title" :placeholder="$t('notification').enterTitleNotification" />
                        </div>
                        <div class="col-md-6 mb-3 ">
                            <p>Type</p>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <i-switch v-model="isUrgent" @on-change="insertTypeUrgent" class="mb-2" />
                                    <Icon size="35" type="md-stopwatch" color="#F4B894" />
                                    <span style="color:#F4B894">{{$t('notification').Urgent}}</span>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <i-switch v-model="isImportant" @on-change="insertTypeImportant" class="mb-2" />
                                    <Icon size="35" type="ios-warning-outline" color="#F26A5A" />
                                    <span style="color:#F26A5A">{{$t('notification').Important}}</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <p class="">{{$t('community').Period}}</p>
                            <RadioGroup @on-change="setPeriodToBlank" v-model="periodType" class="">
                                <Radio label="withPeriod">{{$t('community').ChoosePeriod}}</Radio>
                                <Radio label="withCalendar">{{$t('community').ChooseCalendar}}</Radio>
                            </RadioGroup>   

                            <DatePicker v-if="periodType == 'withCalendar' " class="w-50 mx-auto"  type="daterange" @on-change="notiDateChange" :placeholder="$t('placeholder').selectPeriod" style="display: block" placement="bottom-end"></DatePicker>
                            <RadioGroup v-else v-model="initPeriod" class=" w-50 mx-auto d-flex justify-content-between">
                                <Radio label="forever">{{$t('community').Forever}}</Radio>
                                <Radio label="week">{{$t('community').OneWeek}}</Radio>
                                <Radio label="month">{{$t('community').OneMonth}}</Radio>
                            </RadioGroup> 
                        </div>
                        <div class="col-12 mb-3">
                            <wysiwyg v-model="updateNotificationData.content" :placeholder="$t('placeholder').enterDescription" />
                        </div>
                        <div class="col-12 text-left d-flex justify-content-start mt-3 position-relative">
                            <Upload
                                ref="imageUploads"
                                :headers="{'x-csrf-token': token, 'X-Requested-Width' : 'XMLHttpRequest'}"
                                :on-success="imageSuccess"
                                :on-error="handleError"
                                :format="['jpg','gif','png']"
                                :max-size="2048"
                                :show-upload-list="false"
                                :on-format-error="handleFormatError"
                                :on-exceeded-size="handleMaxSize"
                                accept="image/png, image/jpeg"
                                action="/api/fileUpload/image">
                                    <Icon class="pr-2 noti-upload-icons" size="25" type="ios-image" />
                            </Upload>
                            <Upload
                                ref="otherUploads"
                                :headers="{'x-csrf-token': token, 'X-Requested-Width' : 'XMLHttpRequest'}"
                                :on-success="otherSuccess"
                                :on-error="handleError"
                                :format="['doc','docx','zip','pdf','xls','xlsx','rp','mp3','rp','ppt','pptx','pptm','apk','rar']"
                                :max-size="524288"
                                :show-upload-list="false"
                                :on-format-error="handleFormatError"
                                :on-exceeded-size="handleMaxSize"
                                accept=".doc, .docx, .zip, .pdf, .xls, .xlsx, .rp, .mp3, .rp, .ppt, .pptx, .pptm, .apk, .rar"
                                action="/api/fileUpload/other">
                                    <Icon class="pr-2 noti-upload-icons" size="25" type="ios-folder" />
                            </Upload>
                            <Upload
                                ref="videoUploads"
                                :headers="{'x-csrf-token': token, 'X-Requested-Width' : 'XMLHttpRequest'}"
                                :on-success="videoSuccess"
                                :on-error="handleError"
                                :format="['mp4']"
                                :max-size="524288"
                                :show-upload-list="false"
                                :on-format-error="handleFormatError"
                                :on-exceeded-size="handleMaxSize"
                                accept="video/mp4"
                                action="/api/fileUpload/video">
                                    <Icon class="pr-2 noti-upload-icons" size="25" type="ios-film" />
                            </Upload>
                            <Icon @click="toggleEmo" class="pr-2 noti-upload-icons" size="25" type="md-happy" />
                            <div class="emoji-area-popup">
                                <div v-if="emoStatus" class="position-absolute close-emoji-btn" @click="closeEmojiWindow()">{{$t('common').closeEmoji}}</div>
                                <Picker v-if="emoStatus" set="emojione" @select="onInput" title="Pick your emoji..." />
                            </div>
                            <Button icon="md-create" type="success" class="ml-auto" @click="updateNotification" :disabled="isUpdating" :loading="isUpdating">{{$t('notification').update}}</Button>
                        </div>
                        <div class="col-12 uploaded_file">
                            <div class="image-item" v-if="updateNotificationData.upload_file.imgUrl && updateNotificationData.upload_file.imgUrl.length >0">
                                <div class="image-block">
                                    <div class="image-upload-list" v-for="(imgUrl,i) in updateNotificationData.upload_file.imgUrl" :key="i">
                                        <img :src="imgUrl" alt="">
                                        <div class="demo-upload-list-cover">
                                            <Icon  type="ios-trash-outline" @click="deleteFile('image',imgUrl)"></Icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="file-item row" v-if="updateNotificationData.upload_file.otherUrl.length &&updateNotificationData.upload_file.otherUrl.length>0">
                                <div class="col-6 col-md-4" v-for="(otherUrl,j) in updateNotificationData.upload_file.otherUrl" :key="j">
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
                            <div class="file-item row" v-if="updateNotificationData.upload_file.videoUrl.length && updateNotificationData.upload_file.videoUrl.length>0">
                                <div class="col-6 col-md-4" v-for="(videoUrl,j) in updateNotificationData.upload_file.videoUrl" :key="j">
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

import wysiwyg from "vue-wysiwyg"
//emoji
import { Picker } from 'emoji-mart-vue'
//import Api
import {getCurrentNotificationFromServer, getNotificationList,registerNotification,updateNotification,delNotification} from '~/api/notification'
//file upload component
import Upload from '~/components/Upload'
import {delUploadFile} from '~/api/upload'
import { mapGetters } from 'vuex'
import i18n from '~/plugins/i18n'

export default {
    metaInfo () {
        return { title: this.$t('metaInfo').notificationUpdate }
    },

    components: {
        Picker,     //emoji
    },

    middleware: 'notimanager',
    computed:{ 
        ...mapGetters({
            currentUser: 'auth/user'
        }),
        currentPath(){
            return this.$route
        },
    },

    props:{
        updateNotificationData : Object
    },

    mounted(){
        if(this.updateNotificationData.type == 0){
            this.isUrgent = false;
            this.isImportant = false;
        }
        if(this.updateNotificationData.type == 1){
            this.isUrgent = true;
            this.isImportant = false;
        }
        if(this.updateNotificationData.type == 2){
            this.isUrgent = false;
            this.isImportant = true;
        }
        if(this.updateNotificationData.type == 3){
            this.isUrgent = true;
            this.isImportant = true;
        }
    },

    data(){
        return{
            token:'',
            baseUrl:window.base_url,
            // updateNotificationData: null,

            //emoji
            emoStatus:false,

            initPeriod:'forever',
            periodType:'withPeriod',
            isUpdating:false,
            typeOfData:[],
            isUrgent: false,
            isImportant:false
        }
    },

    created(){
        this.notificationId = this.currentPath.params.id;
        this.token = window.Laravel.csrfToken
        // this.getCurrentNotification();
    },

    methods:{

        insertTypeUrgent(status){
            this.isUrgent = status;
        },

        insertTypeImportant(status){
            this.isImportant = status;
        },


        getCurrentNotification(){
            getCurrentNotificationFromServer(this.notificationId)
            .then(res=>{
                this.updateNotificationData = res.data.notificationData;
                this.updateNotificationData.upload_file = JSON.parse(this.updateNotificationData.upload_file);
                if(this.updateNotificationData.type == 0){
                    this.isUrgent = false;
                    this.isImportant = false;
                }
                if(this.updateNotificationData.type == 1){
                    this.isUrgent = true;
                    this.isImportant = false;
                }
                if(this.updateNotificationData.type == 2){
                    this.isUrgent = false;
                    this.isImportant = true;
                }
                if(this.updateNotificationData.type == 3){
                    this.isUrgent = true;
                    this.isImportant = true;
                }
            })
        },

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
            if(!this.updateNotificationData.desc){
                this.updateNotificationData.desc = e.native
            }else{
                this.updateNotificationData.desc = this.updateNotificationData.desc + e.native
            }
        },

        notiDateChange(date){
            this.updateNotificationData.period = date;
        },

        setPeriodToBlank(){
            this.updateNotificationData.period = '';
        },

        async updateNotification(){
            if(this.updateNotificationData.title.trim() == ''){
                return this.error(i18n.t('alert').title);
            }
            
            if(this.periodType == 'withPeriod'){
                this.updateNotificationData.period = this.initPeriod;
                if(this.updateNotificationData.period.trim() == ''){
                    return this.error(i18n.t('alert').period);
                }
            }
            else{
                if(this.updateNotificationData.period.length == 0){
                    return this.error(i18n.t('alert').period);
                }
            }
            if(this.updateNotificationData.content.trim() == ''){
                return this.error(i18n.t('alert').desc);
            }

            if(this.isUrgent == true){
                this.updateNotificationData.type = 1;
            }
            if(this.isImportant == true){
                this.updateNotificationData.type = 2;
            }
            if(this.isUrgent == true && this.isImportant == true){
                this.updateNotificationData.type = 3;
            }

            if(this.isUrgent == false && this.isImportant == false){
                this.updateNotificationData.type = 0;
            }
            
            this.isUpdating = true;
            console.log(this.updateNotificationData);
            await updateNotification(this.updateNotificationData)
            .then(res=>{
                this.updateNotificationData.title = '';
                this.updateNotificationData.desc = '';
                this.updateNotificationData.period = '';
                this.updateNotificationData.type =  0;
                this.$router.push({path:'/notification/index'})
            })
            .catch(err=>{
                console.log(err);
            })
            this.isUpdating = false
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
                        this.updateNotificationData.upload_file.imgUrl.pop(fileName)
                    }else if(type == 'other'){
                        this.updateNotificationData.upload_file.otherUrl.pop(fileName)
                    }else if(type == 'video'){
                        this.updateNotificationData.upload_file.videoUrl.pop(fileName)
                    }
                })
            .catch(err=>{
                console.log(err);
            })
        },

        //listen event from Upload
        upImgUrl(value) {
            this.updateNotificationData.upload_file.imgUrl.push(value);
        },
        upFileUrl(value) {
            this.updateNotificationData.upload_file.otherUrl.push(value);
        },
        upVideoUrl(value) {
            this.updateNotificationData.upload_file.videoUrl.push(value);
        },

        handleError (res, file) {
            this.$Message.warning(`${file.errors.file.length ? file.errors.file[0] : '出问题了！'}`)
        },
        handleFormatError (file) {
            this.$Message.warning('Format of ' + file.name + ' is not correct');
        },
        handleMaxSize (file) {
            this.$Message.warning('Size of' + file.name + ' could not over than 2M');
        },
        imageSuccess (res, file) {
            res = `/uploads/image/${res}`
            this.updateNotificationData.upload_file.imgUrl.push(res);
        },
        otherSuccess (res, file) {
            let url = `/uploads/other/${res}`;
            this.updateNotificationData.upload_file.otherUrl.push(res);
        },
        videoSuccess(res,file){
            let url = `uploads/video/${res}`
            this.updateNotificationData.upload_file.videoUrl.push(res);
        },
    }
}
</script>