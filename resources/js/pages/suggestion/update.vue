<template>
    <div class="container-fluid bg-light-gray m-0 p-0 pb-5">
        <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 pb-5 pt-2">
                <h2 class="p-3">{{ $t('suggest').UpdateSuggestion }}</h2>
                <Form :model="updateSuggestionData" v-if=" updateSuggestionData !== null">
                    <div class="row m-0 p-0">
                        <div class="col-12 mb-3 newtopic">
                            <Input v-model="updateSuggestionData.title" :placeholder=" $t('placeholder').enterTitle " />
                        </div>
                        <div class="col-12 mb-3">
                            <wysiwyg v-model="updateSuggestionData.content" :placeholder=" $t('placeholder').enterDescription " />
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
                            <Button icon="md-create" type="success" class="ml-auto" @click="updateSuggestion" :disabled="isUpdating" :loading="isUpdating">{{ $t('suggest').UpdateSuggestion }}</Button>
                        </div>
                        <div class="col-12 uploaded_file">
                            <div class="image-item" v-if="updateSuggestionData.upload_file.imgUrl && updateSuggestionData.upload_file.imgUrl.length >0">
                                <div class="image-block">
                                    <div class="image-upload-list" v-for="(imgUrl,i) in updateSuggestionData.upload_file.imgUrl" :key="i">
                                        <img :src="imgUrl" alt="">
                                        <div class="demo-upload-list-cover">
                                            <Icon  type="ios-trash-outline" @click="deleteFile('image',imgUrl)"></Icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="file-item row" v-if="updateSuggestionData.upload_file.otherUrl.length &&updateSuggestionData.upload_file.otherUrl.length>0">
                                <div class="col-6 col-md-4" v-for="(otherUrl,j) in updateSuggestionData.upload_file.otherUrl" :key="j">
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
                            <div class="file-item row" v-if="updateSuggestionData.upload_file.videoUrl.length && updateSuggestionData.upload_file.videoUrl.length>0">
                                <div class="col-6 col-md-4" v-for="(videoUrl,j) in updateSuggestionData.upload_file.videoUrl" :key="j">
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
import {getSuggestionList,updateSuggestion,delSuggestion} from '~/api/suggestion'
import {delUploadFile} from '~/api/upload'

import { mapGetters } from 'vuex'
import i18n from '~/plugins/i18n'   

export default {
    metaInfo () {
        return { title: this.$t('metaInfo').suggestionUpdate }
    },
    middleware: 'auth',

    components: {
        Picker,     //emoji
        Upload,
    },

    props:{
        updateSuggestionData : Object
    },

    mounted(){
    },

    computed:{ 
        ...mapGetters({
            currentUser: 'auth/user'
        }),
        currentPath(){
            return this.$route
        },
    },

    data(){
        return{
            //emoji
            emoStatus:false,

            isUpdating:false,
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
            if(!this.updateSuggestionData.content){
                this.updateSuggestionData.content = e.native
            }else{
                this.updateSuggestionData.content = this.updateSuggestionData.content + e.native
            }
        },

        async updateSuggestion(){
            this.emoStatus = false;
            if(this.updateSuggestionData.title.trim() == ''){
                return this.error(i18n.t('alert').title);
            }
            if(this.updateSuggestionData.content.trim() == ''){
                return this.error(i18n.t('alert').desc);
            }

            this.isUpdating = true;
            await updateSuggestion(this.updateSuggestionData)
            .then(res=>{

                this.updateSuggestionData.title = '';
                this.updateSuggestionData.content = '';
                this.updateSuggestionData.upload_file.imgUrl = [];
                this.updateSuggestionData.upload_file.otherUrl = [];
                this.updateSuggestionData.upload_file.videoUrl = [];
                this.$router.push({path:'/suggestion/index'})
                
            })
            .catch(err=>{
                console.log(err.status);
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
                        this.updateSuggestionData.upload_file.imgUrl.pop(fileName)
                    }else if(type == 'other'){
                        this.updateSuggestionData.upload_file.otherUrl.pop(fileName)
                    }else if(type == 'video'){
                        this.updateSuggestionData.upload_file.videoUrl.pop(fileName)
                    }
                })
            .catch(err=>{
                console.log(err);
            })
        },

        //listen event from Upload
        upImgUrl(value) {
            this.updateSuggestionData.upload_file.imgUrl.push(value);
        },
        upFileUrl(value) {
            this.updateSuggestionData.upload_file.otherUrl.push(value);
        },
        upVideoUrl(value) {
            this.updateSuggestionData.upload_file.videoUrl.push(value);
        },

    }
}
</script>