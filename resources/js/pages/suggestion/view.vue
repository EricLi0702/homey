<template>
    <div>
        <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 py-5 bg-white">
                <p>something</p>
            </div>
        </div>
        <div class="container m-0 p-0 mx-auto">
            <div class="row m-0 p-0">
                <div class="col-12 col-md-4 m-0 p-0 pr-md-4">
                    <div class="box-block">
                        <div class="community-category-title p-3">
                            Categories
                        </div>
                        <div class="community-category-list p-3">
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                        </div>
                    </div>
                    <div class="box-block">
                        <div class="community-category-title p-3">
                            Categories
                        </div>
                        <div class="community-category-list p-3">
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                        </div>
                    </div>
                    <div class="box-block">
                        <div class="community-category-title p-3">
                            Categories
                        </div>
                        <div class="community-category-list p-3">
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>something</p>
                                <Badge type="primary" :count="10"></Badge>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-8 m-0 p-0 pb-4">
                    <div v-if="details !== null" class="posted-item row m-0 p-3">
                        <div class="col-2">
                            <div class="posted-item-user-info">
                                <Avatar icon="ios-person" size="large" />
                            </div>
                        </div>   
                        
                        <div class="col-10">
                            <div class="title">
                                <h3>{{details.title}}</h3>
                            </div>
                            <div class="posted-user-info">
                                <p class="mb-2">posted by {{details.user_id.name}} on {{TimeView(details.created_at)}}</p>
                            </div>
                            <div class="post-content p-2">
                                <p v-html="details.content"></p>
                            </div>
                            <div v-if="details.upload_file.imgUrl.length !== 0" class="post-img row m-0 p-0 mb-4 d-flex align-items-center">
                                <div v-for="(image,i) in details.upload_file.imgUrl" :key="i" class="post-img-item col-4 p-0 px-2" v-viewer>
                                    <img :src="image" alt="" class="w-100 " @click="showImage">
                                </div>
                            </div>

                            <div v-if="details.upload_file.videoUrl.length !== 0" class="post-video row m-0 p-0 mb-4">
                                <div v-for="(video,i) in details.upload_file.videoUrl" :key="i" class="post-video-item col-12">
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
                        <div class="offset-2 col-10 d-flex cnt-info">
                            <div class="cnt d-flex">
                                <div class="reply d-flex mr-4">
                                    <Icon size="25" type="ios-undo" @click="toggleReply"/>
                                </div>
                                <div class="heart d-flex mr-4">
                                    <Icon class="mr-1" v-if="checkIfHeart(details.heart_cnt)" @click="heartPost(details)" size="25" type="md-heart-outline" />
                                    <Icon class="mr-1" v-else  @click="unHeartPost(details)" size="25" type="md-heart" color="#2D8CF0" />
                                    <span v-if="details.heart_cnt !== null">{{details.heart_cnt.length}}</span>
                                    <span v-else>0</span>
                                </div>
                                <div class="like d-flex mr-4">
                                    <Icon class="mr-1" v-if="checkIfLike(details.like_cnt)" @click="likePost(details)" size="25" type="md-thumbs-up" />
                                    <Icon class="mr-1" v-else  @click="unLikePost(details)" size="25" type="md-thumbs-up" color="#2D8CF0" />
                                    <span v-if="details.like_cnt !== null">{{details.like_cnt.length}}</span>
                                    <span v-else>0</span>
                                </div>
                                <div class="dislike d-flex">
                                    <Icon class="mr-1" v-if="checkIfDislike(details.dislike_cnt)" @click="dislikePost(details)" size="25" type="md-thumbs-down" />
                                    <Icon class="mr-1" v-else  @click="unDislikePost(details)" size="25" type="md-thumbs-down" color="#2D8CF0" />
                                    <span v-if="details.dislike_cnt !== null">{{details.dislike_cnt.length}}</span>
                                    <span v-else>0</span>
                                </div>
                            </div>
                        </div>                 
                    </div>
                    <div v-if="isCommenting" class="posted-item mt-3 p-2">
                        <div class="reply-form-comment row p-2">
                            <Input v-model="commentData" type="textarea" placeholder="Leave your comment..." />
                            <div class="d-flex justify-content-between col-12 p-0">
                                <Icon @click="toggleEmo" class="pr-2 noti-upload-icons" size="25" type="md-happy" />
                                <div class="emoji-area-popup">
                                    <Picker v-if="emoStatus" set="emojione" @select="onInput" title="Pick your emoji..." />
                                </div>
                                <Button @click="leaveComment">Leave</Button>
                            </div>
                        </div>
                    </div>
                    <div v-for="(comment,i) in commentsOfCurrentSuggestion" :key="i" v-if="commentsOfCurrentSuggestion.length"  class="posted-item row m-0 p-3 mt-3">
                        <div class="col-2">
                            <div class="posted-item-user-info">
                                <Avatar icon="ios-person" size="large" />
                            </div>
                        </div>   
                        <div class="col-10">
                            <div class="comment-content p-2">
                                <p>{{comment.content}}</p>
                            </div>
                        </div>  
                        <div class="offset-2 col-10">
                            <div class="user-name">
                                <p>{{comment.user_id.name}}</p>
                                <p>{{TimeView(comment.created_at)}}</p>
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
//import Apis
import {leaveCommentToSuggestion, getCurrentSuggestionFromServer, heartToSuggestion, unHeartToSuggestion, likeToSuggestion, dislikeToSuggestion, unLikeToSuggestion, unDislikeToSuggestion } from '~/api/suggestion'
import { mapGetters } from 'vuex'
export default {
    // props:{
    //     details:Object
    // },

    components:{
        Viewer,
        videoPlayer,
        Picker
    },

    data(){
        return{
            suggestionItem : [],
            heart_mine:false,
            like_mine:false,
            dislike_mine:false,
            details:null,
            suggetionId:null,
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
            commentData:null,
            //emoji
            emoStatus:false,
            commentsOfCurrentSuggestion:null,
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
        this.suggetionId = this.currentPath.params.id;
        this.getCurrentSuggestion();
    },
    mounted(){
        // console.log(this.currentPath)
        
        // this.details = JSON.parse(this.currentPath.query.details)
    },
    methods:{

        async leaveComment(){
            console.log("leaveComment", this.commentData);
            if(this.commentData == null){
                return this.error("Please enter comment");
            }
            await leaveCommentToSuggestion(this.commentData, this.details)
            .then(res=>{
                console.log(res);
            })
        },

        toggleEmo(){
            this.emoStatus = !this.emoStatus;
        },

        onInput(e){
            if(!e){
                return false;
            }
            if(!this.commentData){
                this.commentData = e.native
            }else{
                this.commentData = this.commentData + e.native
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

        getCurrentSuggestion(){
            getCurrentSuggestionFromServer(this.suggetionId)
            .then(res=>{
                this.details = res.data.suggestionData[0];
                this.commentsOfCurrentSuggestion = res.data.commentData;
                console.log(this.commentsOfCurrentSuggestion);
                this.details.heart_cnt = JSON.parse(this.details.heart_cnt);
                this.details.like_cnt = JSON.parse(this.details.like_cnt);
                this.details.dislike_cnt = JSON.parse(this.details.dislike_cnt);
                this.details.upload_file = JSON.parse(this.details.upload_file);
            })
        },
        checkIfHeart(heartCntArray){
            if (heartCntArray == null){
                return true;
            }
            else{
                let userId = this.currentUser.id;
                for( let i = 0; i < heartCntArray.length ; i++){
                    if(heartCntArray[i] == userId){
                        return false;
                    }
                }
                return true;
            }
        },
        checkIfLike(likeCntArray){
            if (likeCntArray == null){
                return true;
            }
            else{
                let userId = this.currentUser.id;
                for( let i = 0; i < likeCntArray.length ; i++){
                    if(likeCntArray[i] == userId){
                        return false;
                    }
                }
                return true;
            }
        },
        checkIfDislike(dislikeCntArray){
            if (dislikeCntArray == null){
                return true;
            }
            else{
                let userId = this.currentUser.id;
                for( let i = 0; i < dislikeCntArray.length ; i++){
                    if(dislikeCntArray[i] == userId){
                        return false;
                    }
                }
                return true;
            }
        },

        heartPost(suggest){
            let userId = this.currentUser.id;
            if(suggest.heart_cnt == null){
                suggest.heart_cnt = [userId];
            }
            else{
                for(let i = 0; i < suggest.heart_cnt.length ; i++){
                    if(suggest.heart_cnt[i] == userId){
                        return;
                    }
                }
                suggest.heart_cnt.push(userId);
            }
            heartToSuggestion(suggest)
        },

        likePost(suggest){
            let userId = this.currentUser.id;
            if(suggest.like_cnt == null){
                suggest.like_cnt = [userId];
            }
            else{
                for(let i = 0; i < suggest.like_cnt.length ; i++){
                    if(suggest.like_cnt[i] == userId){
                        return;
                    }
                }
                suggest.like_cnt.push(userId);
            }
            likeToSuggestion(suggest)
        },

        dislikePost(suggest){
            let userId = this.currentUser.id;
            if(suggest.dislike_cnt == null){
                suggest.dislike_cnt = [userId];
            }
            else{
                for(let i = 0; i < suggest.dislike_cnt.length ; i++){
                    if(suggest.dislike_cnt[i] == userId){
                        return;
                    }
                }
                suggest.dislike_cnt.push(userId);
            }
            dislikeToSuggestion(suggest)
        },

        unHeartPost(suggest){
            let userId = this.currentUser.id;
            if(suggest.heart_cnt.length == 1 && suggest.heart_cnt[0] == userId){
                suggest.heart_cnt = null;
            }
            else{
                suggest.heart_cnt = suggest.heart_cnt.filter((n) => {return n != userId});
            }
            unHeartToSuggestion(suggest)
        },

        unLikePost(suggest){
            let userId = this.currentUser.id;
            if(suggest.like_cnt.length == 1 && suggest.like_cnt[0] == userId){
                suggest.like_cnt = null;
            }
            else{
                suggest.like_cnt = suggest.like_cnt.filter((n) => {return n != userId});
            }
            unLikeToSuggestion(suggest)
        },

        unDislikePost(suggest){
            let userId = this.currentUser.id;
            if(suggest.dislike_cnt.length == 1 && suggest.dislike_cnt[0] == userId){
                suggest.dislike_cnt = null;
            }
            else{
                suggest.dislike_cnt = suggest.dislike_cnt.filter((n) => {return n != userId});
            }
            unDislikeToSuggestion(suggest)
        },
    }
}
</script>