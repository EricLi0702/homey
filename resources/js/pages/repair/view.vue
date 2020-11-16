<template>
    <div>
        <!-- <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 py-5 bg-white">
                <p>something</p>
            </div>
        </div> -->
        <div class="container m-0 p-0 mx-auto">
            <div class="row m-0 p-0">
                <Category/>
                <div class="col-12 col-md-8 m-0 p-0 pb-4">
                    <div v-if="details !== null" class="posted-item row m-0 p-3">
                        <div class="col-1">
                            <div class="posted-item-user-info">
                                <img :src="`${baseUrl}${details.user_id.user_avatar}`" class="rounded-circle profile-photo mr-1" alt="">
                            </div>
                        </div>   
                        
                        <div class="col-11">
                            <div class="posted-user-info d-flex justify-content-between">
                                <p class="mb-2">{{details.user_id.name}}</p>
                                <p>{{TimeView(details.created_at)}}</p>
                            </div>
                            <div class="title d-flex justify-content-between">
                                <h3>{{details.title}}</h3>
                                <Tag v-if="details.status == 'pending'" color="warning">{{details.status}}</Tag>
                                <Tag v-else-if="details.status == 'approved'" color="success">{{details.status}}</Tag>
                                <Tag v-else-if="details.status == 'ongoing'" color="primary">{{details.status}}</Tag>
                                <Tag v-else-if="details.status == 'finish'" color="default">{{details.status}}</Tag>
                            </div>
                            <div class="post-content p-2">
                                <p v-html="details.desc"></p>
                            </div>
                            <div v-if="details.upload_file.imgUrl.length !== 0" class="post-img row m-0 p-0 mb-4 d-flex align-items-center">
                                <div v-for="(image,i) in details.upload_file.imgUrl" :key="i" class="post-img-item col-4 p-0 px-2" v-viewer>
                                    <img :src="image" alt="" class="w-100 " @click="showImage">
                                </div>
                            </div>

                            <div v-if="details.upload_file.videoUrl.length !== 0" class="post-video row m-0 p-0 mb-4">
                                <div v-for="(video,i) in details.upload_file.videoUrl" :key="i" class="post-video-item col-12 p-2">
                                     <video-player  
                                        class="video-player-box vjs-custom-skin w-100"
                                        ref="videoPlayer"
                                        :options="getEachVideoSrc(video)"
                                        :playsinline="true"
                                        @ready="playerReadied(video)"
                                        >
                                    </video-player>
                                </div>
                            </div>
                        
                            <div v-if="details.upload_file.otherUrl.length !== 0" class="post-file row m-0 p-0 d-flex align-items-center mb-4">
                                <div v-for="(file,i) in details.upload_file.otherUrl" :key="i" class="post-file-item col-lg-6 col-12 p-0 px-2 mb-2">
                                    <div class="d-flex align-items-center p-1 bg-light-gray position-relative">
                                        <Icon class="mr-2" size="35" type="ios-document-outline" />
                                        <div class="file-info">
                                            <p><strong>{{file.fileOriName}}</strong></p>
                                            <p><small>{{file.fileSize}}</small></p>
                                        </div>
                                        <a class="download-icon" :href="`${baseUrl}/upload/other/${file.fileName}`" :download="file.fileOriName">
                                            <Icon size="25" class="msg-file-download-ico msg-file-download-ico-send" type="md-download" />
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>    
                        <div class="offset-1 col-11 d-flex cnt-info">
                            <div class=" d-flex w-100">
                                <div v-if="currentUser.id == details.userId" class="w-100 remove d-flex justify-content-between align-items-center">
                                    <Poptip
                                        confirm
                                        title="Are you sure you want to delete this request?"
                                        ok-text="Yes"
                                        cancel-text="Cancel"
                                        placement="right"
                                        @on-ok="removeRequest(details)"
                                        @on-cancel="cancelRemoveRequest">
                                        <Icon size="25" class="mr-4" type="md-trash"/>
                                    </Poptip>
                                    <Icon v-if="details.status !== 'finish'" @click="toggleFinishRequest" size="40" class="mr-4" type="md-power"/>
                                    <Rate v-else disabled class="w-100 text-right" v-model="details.star" />
                                </div>

                                <div v-else-if="currentUser.roleId == 2 || currentUser.roleId == 7" class="reply ml-auto">
                                    <Icon size="25" type="ios-undo" @click="toggleReply"/>
                                </div>
                            </div>
                        </div>                 
                    </div>
                    <div v-if="details !== null" class="navigte-item d-flex justify-content-center mt-3">
                        <ButtonGroup shape="circle">
                            <Button @click="getFirstItem" type="primary" icon="ios-skip-backward"></Button>
                            <Button @click="getPreviousItem" type="primary" icon="md-arrow-round-back"></Button>
                            <Button @click="getNextItem" type="primary" icon="md-arrow-round-forward"></Button>
                            <Button @click="getLastItem" type="primary" icon="ios-skip-forward"></Button>
                        </ButtonGroup>
                    </div>

                    <div v-if="isResponsing" class="posted-item mt-3 p-2 animate__animated animate__fadeIn">
                        <div class="reply-form-comment m-0 row p-2">
                            <Input v-model="responseData" type="textarea" placeholder="Enter Response..." />
                            <div class="d-flex justify-content-between col-12 p-0">
                                <Icon @click="toggleEmo" class="pr-2 noti-upload-icons" size="25" type="md-happy" />
                                <div class="emoji-area-popup">
                                    <Picker v-if="emoStatus" set="emojione" @select="onInput" title="Pick your emoji..." />
                                </div>
                                <Button @click="responseToRepairRequest" :loading="isResponsingTo" :disabled="isResponsingTo">{{ $t('repair').Response }}</Button>
                            </div>
                        </div>
                    </div>
                    <div v-if="isFinishRequest" class="posted-item mt-3 p-2 animate__animated animate__fadeIn">
                        <div class="reply-form-comment m-0 row p-2">
                            <Rate class="w-100 text-center" v-model="rateOfResponse" />
                            <Input v-model="finishRequestData" type="textarea" :placeholder=" $t('repair').EnterReview " />
                            <div class="d-flex justify-content-between col-12 p-0">
                                <Icon @click="toggleEmoOfFinishRequestData" class="pr-2 noti-upload-icons" size="25" type="md-happy" />
                                <div class="emoji-area-popup">
                                    <Picker v-if="emoStatusOfFinishRequestData" set="emojione" @select="onInputOfFinishRequestData" title="Pick your emoji..." />
                                </div>
                                <Button @click="finishRequest(details)" :loading="isFinishingRequest" :disabled="isFinishingRequest">{{ $t('repair').LeaveReview }}</Button>
                            </div>
                        </div>
                    </div>
                    
                    <div v-for="(responseComment,i) in responseCommentData" :key="i" v-if="responseCommentData.length"  class="posted-item row m-0 p-3 mt-3">
                        <div class="col-1">
                            <div class="posted-item-user-info">
                                <img :src="`${baseUrl}${responseComment.user_id.user_avatar}`" class="rounded-circle profile-photo mr-1" alt="">
                            </div>
                        </div>   
                        <div class="col-11">
                            <div class="posted-user-info d-flex justify-content-between">
                                <p class="mb-2">{{responseComment.user_id.name}}</p>
                                <p>{{TimeView(responseComment.created_at)}}</p>
                            </div>
                            <div class="comment-content p-2">
                                <p>{{responseComment.replyToClient}}</p>
                            </div>
                            <div v-if="responseComment.user_id.id !== currentUser.id" class="reply ml-auto">
                                <Icon size="25" type="ios-undo" @click="toggleReply"/>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
//emoji
import { Picker } from 'emoji-mart-vue'
//image viewer
import 'viewerjs/dist/viewer.css'
import Viewer from 'v-viewer'
//video viewer
import 'video.js/dist/video-js.css'
import { videoPlayer } from 'vue-video-player'
//infinitLoding
import InfiniteLoading from 'vue-infinite-loading';
//import Apis
import {
    responseToRepairRequest, 
    getCurrentRepairFromServer, 
    deleteRequest,
    finishRequest,
    getFirstItem,
    getLastItem,
    getPreviousItem,
    getNextItem,
} from '~/api/repair'

import Category from './category'

import { mapGetters } from 'vuex'
export default {
    // props:{
    //     details:Object
    // },

    components:{
        Viewer,
        videoPlayer,
        Picker,
        Category
    },

    data(){
        return{
            baseUrl:window.base_url,
            suggestionItem : [],
            details:null,
            repairId:null,
            responseCommentData:null,
            isFinishRequest:false,
            playerOptions: {
            // videojs options
                height:'350',
                muted: true,
                language: 'en',
                playbackRates: [0.7, 1.0, 1.5, 2.0],
                sources: [{
                    type: "video/mp4",
                    src: "https://cdn.theguardian.tv/webM/2015/07/20/150716YesMen_synd_768k_vp8.webm"
                }],
                // poster: "/static/images/author.jpg",
            },

            //comment
            isResponsing:false,
            isResponsingTo:false,
            responseData:null,
            isFinishingRequest:false,
            //emoji
            emoStatus:false,
            emoStatusOfFinishRequestData:false,
            finishRequestData:null,
            commentsOfCurrentSuggestion:[],
            rateOfResponse:0,
            //infinit loading
            pageOfComments: 1,
            lastPageOfComments: 0,
            baseUrl:window.base_url
        }
    },
    computed:{ 
        ...mapGetters({
            currentUser: 'auth/user'
        }),
        currentPath(){
            return this.$route
        },
        player() {
            return this.$refs.videoPlayer.player
        }
    },

    created(){
        // console.log(this.currentPath)
        this.repairId = this.currentPath.params.id;
        this.getCurrentRepair();
    },
    mounted(){
        // console.log(this.currentPath)
        
        // this.details = JSON.parse(this.currentPath.query.details)
    },
    methods:{

        getPreviousItem(){
            getPreviousItem(this.repairId)
            .then(res=>{
                if(res.data == ""){
                    return this.error("This is the first.");
                }
                this.$router.push({ path:`/repair/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },
        
        getNextItem(){
            getNextItem(this.repairId)
            .then(res=>{
                if(res.data == ""){
                    return this.error("This is the last.");
                }
                this.$router.push({ path:`/repair/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },

        getFirstItem(){
            getFirstItem()
            .then(res=>{
                this.$router.push({ path:`/repair/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },

        getLastItem(){
            getLastItem()
            .then(res=>{
                this.$router.push({ path:`/repair/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },

        async responseToRepairRequest(){
            console.log("reply to request", this.responseData);
            if(this.details.status == "finish"){
                return this.error("This thread has been broken.");
            }
            if(this.responseData == null){
                return this.error("Please enter comment");
            }
            this.isResponsingTo = true;
            await responseToRepairRequest(this.responseData, this.details)
            .then(res=>{
                console.log(res.data.responseData);
                let responseCommentCurrently = res.data.responseData;
                this.responseData = null;
                this.responseCommentData.unshift(responseCommentCurrently);
            })
            this.isResponsing = false;
            this.isResponsingTo = false;
        },

        toggleEmo(){
            this.emoStatus = !this.emoStatus;
        },

        onInput(e){
            if(!e){
                return false;
            }
            if(!this.responseData){
                this.responseData = e.native
            }else{
                this.responseData = this.responseData + e.native
            }
        },
        toggleEmoOfFinishRequestData(){
            this.emoStatusOfFinishRequestData = !this.emoStatusOfFinishRequestData;
        },

        onInputOfFinishRequestData(e){
            if(!e){
                return false;
            }
            if(!this.finishRequestData){
                this.finishRequestData = e.native
            }else{
                this.finishRequestData = this.finishRequestData + e.native
            }
        },

        toggleReply(){
            this.isResponsing = !this.isResponsing;
        },
        
        playerReadied(video){
            this.playerOptions.sources[0].src = this.baseUrl+'/uploads/video/'+video.fileName;
        },

        showImage(){
            const viewer = this.$el.getElementsByClassName('post-img-item').$viewer
            viewer.show()
        },

        getEachVideoSrc(video){
            this.playerOptions.sources[0].src = this.baseUrl+'/uploads/video/'+video.fileName;
            return this.playerOptions
        },

        getCurrentRepair(){
            getCurrentRepairFromServer(this.repairId)
            .then(res=>{
                console.log("ddd",res.data.repairData);
                this.responseCommentData = res.data.repairData.repair_id;
                this.details = res.data.repairData;
                this.details.upload_file = JSON.parse(this.details.upload_file);
            })
        },

        removeRequest(request){
            deleteRequest(request)
            .then(res=>{
                if(res.status == 204){
                    this.success('successfully deleted');
                    this.$router.push({name:'repair.list'})
                }
            })
            .catch(err=>{
                console.log(err);
            })
        },

        cancelRemoveRequest(){
            console.log("canceled");
        },

        toggleFinishRequest(){
            this.isFinishRequest = !this.isFinishRequest;
            this.rateOfResponse = 0;
            this.emoStatusOfFinishRequestData = false;
            this.finishRequestData = null;
        },

        finishRequest(request){
            if(request.status == 'finish'){
                return this.error("This thread has been broken.");
            }
            if(this.rateOfResponse == 0){
                return this.error("Please select rating");
            }
            if(this.finishRequestData == null || this.finishRequestData.trim() == ''){
                return this.error("Please enter your review");
            }

            let payload = {};
            payload['repairData'] = request;
            payload['rating'] = this.rateOfResponse;
            payload['finishRequestData'] = this.finishRequestData;

            this.isFinishingRequest = true;
            finishRequest(payload)
            .then(res=>{
                if(res.status == 200){
                    this.success('successfully finished');
                    this.$router.push({name:'repair.list'})
                }
            })
            .catch(err=>{
                console.log(err);
            })
            this.isFinishingRequest = false;
        },

        cancelFinishRequest(){
            console.log("canceled");
        },
        
    }
}
</script>
