<template>
    <div class="container-fluid bg-light-gray m-0 p-0 pb-5">
        <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 py-5">
                <h2 class="p-3">New Suggestion</h2>
                <Form :model="createSuggestionData">
                    <div class="row m-0 p-0">
                        <div class="col-12 mb-3 newtopic">
                            <Input v-model="createSuggestionData.title" placeholder="please enter title" />
                        </div>
                        <div class="col-12 mb-3">
                            <wysiwyg v-model="createSuggestionData.desc" placeholder="please enter description" />
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
                            <Button class="ml-auto" @click="registerSuggestion" :disabled="isSuggesting" :loading="isSuggesting">Suggest</Button>
                        </div>
                        <div class="col-12 uploaded_file">
                            <div class="image-item" v-if="createSuggestionData.file.imgUrl && createSuggestionData.file.imgUrl.length >0">
                                <div class="image-block">
                                    <div class="image-upload-list" v-for="(imgUrl,i) in createSuggestionData.file.imgUrl" :key="i">
                                        <img :src="imgUrl" alt="">
                                        <div class="demo-upload-list-cover">
                                            <Icon  type="ios-trash-outline" @click="deleteFile('image',imgUrl)"></Icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="file-item row" v-if="createSuggestionData.file.otherUrl.length &&createSuggestionData.file.otherUrl.length>0">
                                <div class="col-4" v-for="(otherUrl,j) in createSuggestionData.file.otherUrl" :key="j">
                                    <div class="image-upload-list float-left">
                                        <img src="/img/icon/icon_rar@2x.png" alt="">
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
                            <div class="file-item row" v-if="createSuggestionData.file.videoUrl.length && createSuggestionData.file.videoUrl.length>0">
                                <div class="col-4" v-for="(videoUrl,j) in createSuggestionData.file.videoUrl" :key="j">
                                    <div class="image-upload-list float-left">
                                        <img src="/img/icon/icon_mp4@2x.png" alt="">
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
import {getSuggestionList,registerSuggestion,updateSuggestion,delSuggestion} from '~/api/suggestion'
import {delUploadFile} from '~/api/upload'

export default {
    middleware: 'auth',

    components: {
        Picker,     //emoji
        Upload,
    },

    data(){
        return{
            baseUrl:window.base_url,
            createSuggestionData: {
                title: '',
                desc: '',
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
            isSuggesting:false,
            typeOfData:[],


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
            if(!this.createSuggestionData.desc){
                this.createSuggestionData.desc = e.native
            }else{
                this.createSuggestionData.desc = this.createSuggestionData.desc + e.native
            }
        },

        notiDateChange(date){
            this.createSuggestionData.period = date;
        },

        setPeriodToBlank(){
            this.createSuggestionData.period = '';
        },

        async registerSuggestion(){
            this.emoStatus = false;
            if(this.createSuggestionData.title.trim() == ''){
                return this.error('Title is required')
            }
            if(this.createSuggestionData.desc.trim() == ''){
                return this.error('Description is required')
            }

            this.isSuggesting = true;
            await registerSuggestion(this.createSuggestionData)
            .then(res=>{
                // let newSuggestion = res.data.suggestion;
                // console.log(newSuggestion);
                // let parsed = JSON.parse(newSuggestion.upload_file);
                // console.log(parsed);
                this.createSuggestionData.title = '';
                this.createSuggestionData.desc = '';
                this.createSuggestionData.file.imgUrl = [];
                this.createSuggestionData.file.otherUrl = [];
                this.createSuggestionData.file.videoUrl = [];
                
            })
            .catch(err=>{
                console.log(err);
            })
            this.isSuggesting = false
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
                        this.createSuggestionData.file.imgUrl.pop(fileName)
                    }else if(type == 'other'){
                        this.createSuggestionData.file.otherUrl.pop(fileName)
                    }else if(type == 'video'){
                        this.createSuggestionData.file.videoUrl.pop(fileName)
                    }
                })
            .catch(err=>{
                console.log(err);
            })
            // if(res.status == 200){
            //     if(type == 'image'){
            //         this.createSuggestionData.file.imgUrl.pop(fileName)
            //     }else if(type == 'other'){
            //         this.createSuggestionData.file.otherUrl.pop(fileName)
            //     }else if(type == 'video'){
            //         this.createSuggestionData.file.videoUrl.pop(fileName)
            //     }
            // }else{
            //     this.swr();
            // }
        },

        //listen event from Upload
        upImgUrl(value) {
            this.createSuggestionData.file.imgUrl.push(value);
        },
        upFileUrl(value) {
            this.createSuggestionData.file.otherUrl.push(value);
        },
        upVideoUrl(value) {
            this.createSuggestionData.file.videoUrl.push(value);
        },

    }
}
</script>