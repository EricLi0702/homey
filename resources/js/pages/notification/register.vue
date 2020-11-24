<template>
    <div class="container-fluid bg-light-gray m-0 p-0 pb-5">
        <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 pb-5 pt-2">
                <h2 class="p-3">{{$t('notification').RegisterNewNotification}}</h2>
                <Form :model="registerNotificationData">
                    <div class="row m-0 p-0">
                        <div class="col-md-6 mb-3 gray-input">
                            <p>{{$t('notification').title}}</p>
                            <Input v-model="registerNotificationData.title" :placeholder="$t('notification').enterTitleNotification" />
                        </div>
                        <div class="col-md-6 mb-3 ">
                            <p>{{$t('notification').Type}}</p>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <i-switch @click="insertTypeUrgent" v-model="isUrgent" class="mb-2" />
                                    <Icon size="35" type="md-stopwatch" color="#F4B894" />
                                    <span style="color:#F4B894">{{$t('notification').Urgent}}</span>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <i-switch @click="insertTypeImportant" v-model="isImportant" class="mb-2" />
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
                            <wysiwyg v-model="registerNotificationData.desc" :placeholder="$t('placeholder').enterDescription" />
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
                            <Button icon="ios-briefcase-outline" type="warning" class="ml-auto mr-2" @click="saveToDraftNotification" :disabled="isSavingDraft" :loading="isSavingDraft">{{$t('notification').Draft}}</Button>
                            <Button icon="ios-send" type="success" class="" @click="registerNotification" :disabled="isRegistering" :loading="isRegistering">{{$t('register').register}}</Button>
                        </div>
                        <div class="col-12 uploaded_file">
                            <div class="image-item" v-if="registerNotificationData.file.imgUrl && registerNotificationData.file.imgUrl.length >0">
                                <div class="image-block">
                                    <div class="image-upload-list" v-for="(imgUrl,i) in registerNotificationData.file.imgUrl" :key="i">
                                        <img :src="imgUrl" alt="">
                                        <div class="demo-upload-list-cover">
                                            <Icon  type="ios-trash-outline" @click="deleteFile('image',imgUrl)"></Icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="file-item row" v-if="registerNotificationData.file.otherUrl.length &&registerNotificationData.file.otherUrl.length>0">
                                <div class="col-6 col-md-4" v-for="(otherUrl,j) in registerNotificationData.file.otherUrl" :key="j">
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
                            <div class="file-item row" v-if="registerNotificationData.file.videoUrl.length && registerNotificationData.file.videoUrl.length>0">
                                <div class="col-6 col-md-4" v-for="(videoUrl,j) in registerNotificationData.file.videoUrl" :key="j">
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
import { locale } from 'view-design';
import en from 'view-design/dist/locale/en-US';
import ko from 'view-design/dist/locale/ko-KR';
import vn from 'view-design/dist/locale/vi-VN';


//
import wysiwyg from "vue-wysiwyg"
//emoji
import { Picker } from 'emoji-mart-vue'
//import Api
import {getNotificationList,registerNotification,updateNotification,delNotification, getDraft} from '~/api/notification'
//file upload component
import Upload from '~/components/Upload'
import {delUploadFile} from '~/api/upload'
import { mapGetters } from 'vuex'
import i18n from '~/plugins/i18n'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').registerNotification }
    },
    middleware: 'notimanager',

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
                    locale(en);
                }
                if(val == 'kr'){
                    locale(ko);
                }
                if(val == 'vn'){
                    locale(vn);
                }
            },
            deep:true
        }
    },


    data(){
        return{
            baseUrl:window.base_url,
            registerNotificationData: {
                title: '',
                desc: '',
                period: '',
                type: 0,
                isDraft: null,
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
            isRegistering:false,

            //draft
            isSavingDraft: false,
            //fix type
            isUrgent:  false,
            isImportant: false
        }
    },

    created(){
        this.getDraft();
        if(this.currentLang == 'en'){
            locale(en);
        }
        if(this.currentLang == 'kr'){
            locale(ko);
        }
        if(this.currentLang == 'vn'){
            locale(vn);
        }
    },

    methods:{
        getDraft(){
            getDraft()
            .then(res=>{
                if(res.data.draftData.length !== 0){
                    this.success(i18n.t('alert').alreadyDraft);
                    this.registerNotificationData.file = JSON.parse(res.data.draftData[0].upload_file);
                    this.registerNotificationData.title = res.data.draftData[0].title;
                    this.registerNotificationData.desc = res.data.draftData[0].content;
                    this.registerNotificationData.type = res.data.draftData[0].type;
                    this.registerNotificationData['id'] = res.data.draftData[0].id;
                    switch (this.registerNotificationData.type) {
                        case 0:
                            this.isUrgent = false;
                            this.isImportant = false;
                            break;
                        case 1:
                            this.isUrgent = true;
                            this.isImportant = false;
                            break;
                        case 2:
                            this.isUrgent = false;
                            this.isImportant = true;
                            break;
                        case 3:
                            this.isUrgent = true;
                            this.isImportant = true;
                            break;
                    }
                }
            })
            .catch(err => {
                console.log(err.response)
            });
        },

        insertTypeUrgent(){
            this.isUrgent = !this.isUrgent;
        },

        insertTypeImportant(){
            this.isImportant = !this.isImportant;
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
            if(!this.registerNotificationData.desc){
                this.registerNotificationData.desc = e.native
            }else{
                this.registerNotificationData.desc = this.registerNotificationData.desc + e.native
            }
        },

        notiDateChange(date){
            this.registerNotificationData.period = date;
        },

        setPeriodToBlank(){
            this.registerNotificationData.period = '';
        },

        async registerNotification(){
            if(this.registerNotificationData.title.trim() == ''){
                return this.error(i18n.t('alert').title);
            }
        
            if(this.periodType == 'withPeriod'){
                this.registerNotificationData.period = this.initPeriod;
                if(this.registerNotificationData.period.trim() == ''){
                    return this.error(i18n.t('alert').period);
                }
            }
            else{
                if(this.registerNotificationData.period.length == 0){
                    return this.error(i18n.t('alert').period);
                }
            }
            if(this.registerNotificationData.desc.trim() == ''){
                return this.error(i18n.t('alert').desc);
            }

            if(this.isUrgent == true){
                this.registerNotificationData.type = 1;
            }
            if(this.isImportant == true){
                this.registerNotificationData.type = 2;
            }
            if(this.isUrgent == true && this.isImportant == true){
                this.registerNotificationData.type = 3;
            }

            if(this.isUrgent == false && this.isImportant == false){
                this.registerNotificationData.type = 0;
            }

            this.isRegistering = true;

            await registerNotification(this.registerNotificationData)
            .then(res=>{
                this.registerNotificationData.title = '';
                this.registerNotificationData.desc = '';
                this.registerNotificationData.period = '';
                this.registerNotificationData.type =  0;
                this.$router.push({path:'/notification/index'})
            })
            .catch(err=>{
                console.log(err);
            })
            this.isRegistering = false
        },

        async saveToDraftNotification(){
            if(this.registerNotificationData.title.trim() == ''){
                return this.error(i18n.t('alert').title);
            }
            if(this.periodType == 'withPeriod'){
                this.registerNotificationData.period = this.initPeriod;
                if(this.registerNotificationData.period.trim() == ''){
                    return this.error(i18n.t('alert').period);
                }
            }
            else{
                if(this.registerNotificationData.period.length == 0){
                    return this.error(i18n.t('alert').period);
                }
            }
            if(this.registerNotificationData.desc.trim() == ''){
                return this.error(i18n.t('alert').desc);
            }
            if(this.isUrgent == true){
                this.registerNotificationData.type = 1;
            }
            if(this.isImportant == true){
                this.registerNotificationData.type = 2;
            }
            if(this.isUrgent == true && this.isImportant == true){
                this.registerNotificationData.type = 3;
            }

            if(this.isUrgent == false && this.isImportant == false){
                this.registerNotificationData.type = 0;
            }

            this.registerNotificationData.isDraft = true;
            this.isSavingDraft = true;

            await registerNotification(this.registerNotificationData)
            .then(res=>{
                this.registerNotificationData.title = '';
                this.registerNotificationData.desc = '';
                this.registerNotificationData.period = '';
                this.registerNotificationData.type =  0;
                this.$router.push({path:'/notification/index'})
            })
            .catch(err=>{
                console.log(err);
            })

            this.isSavingDraft = false;
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
                        this.registerNotificationData.file.imgUrl.pop(fileName)
                    }else if(type == 'other'){
                        this.registerNotificationData.file.otherUrl.pop(fileName)
                    }else if(type == 'video'){
                        this.registerNotificationData.file.videoUrl.pop(fileName)
                    }
                })
            .catch(err=>{
                console.log(err);
            })
        },

        //listen event from Upload
        upImgUrl(value) {
            this.registerNotificationData.file.imgUrl.push(value);
        },
        upFileUrl(value) {
            this.registerNotificationData.file.otherUrl.push(value);
        },
        upVideoUrl(value) {
            this.registerNotificationData.file.videoUrl.push(value);
        },
    }
}
</script>