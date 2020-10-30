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
                                <img style="width:40px;" :src="`${baseUrl}/asset/img/icon/avatar.png`" class="rounded-circle profile-photo mr-1" alt="">
                                <!-- <img src="https://i.pravatar.cc/40" alt=""> -->
                            </div>
                        </div>   
                        
                        <div class="col-11">
                            <div class="posted-user-info d-flex justify-content-between">
                                <p class="mb-2">{{details.user_id.name}}</p>
                                <p>{{TimeView(details.created_at)}}</p>
                            </div>
                            <div class="title">
                                <h3>{{details.title}}</h3>
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
                                        <a class="download-icon" :href="`http://asystem.test/upload/other/${file.fileName}`" :download="file.fileOriName">
                                            <Icon size="25" class="msg-file-download-ico msg-file-download-ico-send" type="md-download" />
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>    
                        <div class="offset-1 col-11 d-flex cnt-info">
                            <div class="cnt d-flex w-100">
                                <div v-if="currentUser.id == details.userId" class="remove mr-auto">
                                    <Poptip
                                        confirm
                                        title="Are you sure you want to delete this suggestion?"
                                        ok-text="Yes"
                                        cancel-text="Cancel"
                                        placement="right"
                                        @on-ok="removeRequest"
                                        @on-cancel="cancelRemoveRequest">
                                        <Icon size="25" class="mr-4" type="md-trash"/>
                                    </Poptip>
                                </div>
                                <!-- <div v-else class="reply mr-auto">
                                    <div v-if="details.comment_cnt !== null && details.comment_cnt.includes(currentUser.id)" class="reply d-flex mr-4">
                                        <p>You have already commented.</p>
                                    </div>
                                    <div v-else class="reply d-flex mr-4">
                                        <Icon size="25" type="ios-undo" @click="toggleReply"/>
                                    </div>
                                </div> -->
                            </div>
                        </div>                 
                    </div>
                    <!-- <div v-if="isCommenting" id="commentArea" class="posted-item mt-3 p-2 animate__animated animate__fadeIn">
                        <div class="reply-form-comment row p-2">
                            <Input v-model="responseData" type="textarea" placeholder="Leave your comment..." />
                            <div class="d-flex justify-content-between col-12 p-0">
                                <Icon @click="toggleEmo" class="pr-2 noti-upload-icons" size="25" type="md-happy" />
                                <div class="emoji-area-popup">
                                    <Picker v-if="emoStatus" set="emojione" @select="onInput" title="Pick your emoji..." />
                                </div>
                                <Button @click="leaveComment">Leave</Button>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div v-for="(comment,i) in commentsOfCurrentSuggestion" :key="i" v-if="commentsOfCurrentSuggestion.length"  class="posted-item row m-0 p-3 mt-3">
                        <div class="col-1">
                            <div class="posted-item-user-info">
                                <img style="width:40px;" :src="`${baseUrl}/asset/img/icon/avatar.png`" class="rounded-circle profile-photo mr-1" alt="">
                            </div>
                        </div>   
                        <div class="col-11">
                            <div class="posted-user-info d-flex justify-content-between">
                                <p class="mb-2">{{comment.user_id.name}}</p>
                                <p>{{TimeView(comment.created_at)}}</p>
                            </div>
                            <div class="comment-content p-2">
                                <p>{{comment.content}}</p>
                            </div>
                        </div>  
                    </div>
                    <InfiniteLoading 
                        class="pb-3"
                        @infinite="infiniteHandlerComments"
                        spinner="circles"
                    >
                        <div slot="no-more">no more comments</div>
                    </InfiniteLoading> -->
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
        InfiniteLoading,
        Category
    },

    data(){
        return{
            baseUrl:window.base_url,
            suggestionItem : [],
            details:null,
            repairId:null,
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
            isCommenting:false,
            responseData:null,
            //emoji
            emoStatus:false,
            commentsOfCurrentSuggestion:[],
            //infinit loading
            pageOfComments: 1,
            lastPageOfComments: 0,
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

        async responseToRepairRequest(){
            console.log("reply to request", this.responseData);
            if(this.responseData == null){
                return this.error("Please enter comment");
            }
            // await leaveCommentToSuggestion(this.responseData, this.details)
            // .then(res=>{
            //     console.log(res.data.commentToSuggest);
            //     let commentCurrently = res.data.commentToSuggest;
            //     commentCurrently['created_at'] = Date.now();
            //     commentCurrently['user_id'] = {};
            //     commentCurrently.user_id['name'] = this.currentUser.name;
            //     this.responseData = null;
            //     this.commentsOfCurrentSuggestion.unshift(commentCurrently);
            //     if(this.details.comment_cnt == null) {
            //         this.details.comment_cnt = [];
            //         this.details.comment_cnt.push(this.currentUser.id);
            //     }
            //     else{
            //         this.details.comment_cnt.push(this.currentUser.id);
            //     }
            //     this.isCommenting = false;
            // })
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

        toggleReply(){
            this.isCommenting = !this.isCommenting;
        },
        
        playerReadied(video){
            this.playerOptions.sources.src = "http://asystem.test/uploads/video/"+video.fileName;
        },

        showImage(){
            const viewer = this.$el.getElementsByClassName('post-img-item').$viewer
            viewer.show()
        },

        getEachVideoSrc(video){
            this.playerOptions.sources.src = "http://asystem.test/uploads/video/"+video.fileName;
            return this.playerOptions
        },

        getCurrentRepair(){
            getCurrentRepairFromServer(this.repairId)
            .then(res=>{
                console.log("ddd",res.data.repairData);
                this.details = res.data.repairData;
                this.details.upload_file = JSON.parse(this.details.upload_file);
            })
        },
        
    }
}
</script>
