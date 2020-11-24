<template>
    <div>
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
                            <div class="title">
                                <h3>{{details.title}}</h3>
                            </div>
                            <div class="post-content p-2">
                                <p v-html="details.content"></p>
                            </div>
                            <div v-if="details.upload_file.imgUrl.length !== 0" class="post-img row m-0 p-0 mb-4 d-flex align-items-center">
                                <div v-for="(image,i) in details.upload_file.imgUrl" :key="i" class="post-img-item col-4 p-0 px-2" v-viewer>
                                    <img :src="image" alt="" class="w-100 " @click="showImage" style="height: 150px; margin-bottom: 17px">
                                </div>
                            </div>

                            <div v-if="details.upload_file.videoUrl.length !== 0" class="post-video row m-0 p-0 mb-4">
                                <div v-for="(video,i) in details.upload_file.videoUrl" :key="i" class="post-video-item col-12 p-2">
                                     <video-player  
                                        class="video-player-box vjs-custom-skin w-100"
                                        ref="videoPlayer"
                                        :options="playerOptionsGroup[i]"
                                        :playsinline="true"
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
                            <div class="cnt d-flex w-100">
                                <div v-if="details.isRemoved !== 1" class="d-flex w-100">
                                    <div v-if="currentUser.id == details.userId || currentUser.roleId == 2" class="remove mr-auto">
                                        <Poptip
                                            confirm
                                            title="Are you sure you want to delete this suggestion?"
                                            ok-text="Yes"
                                            cancel-text="Cancel"
                                            placement="right"
                                            @on-ok="removeSuggestion"
                                            @on-cancel="cancelRemoveSuggestion">
                                            <Icon size="25" class="mr-4" type="md-trash"/>
                                        </Poptip>
                                        <Icon @click="editSuggestion(details)" size="25" class="mr-4" type="md-create"/>
                                    </div>
                                    <div v-else class="reply mr-auto">
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
                    </div>
                    <div v-if="details !== null" class="navigte-item d-flex justify-content-center mt-3">
                        <ButtonGroup shape="circle">
                            <Button @click="getFirstItem" type="primary" icon="ios-skip-backward"></Button>
                            <Button @click="getPreviousItem" type="primary" icon="md-arrow-round-back"></Button>
                            <Button @click="getNextItem" type="primary" icon="md-arrow-round-forward"></Button>
                            <Button @click="getLastItem" type="primary" icon="ios-skip-forward"></Button>
                        </ButtonGroup>
                    </div>
                    <div v-if="isCommenting" id="commentArea" class="posted-item mt-3 p-2 animate__animated animate__fadeIn">
                        <div class="reply-form-comment row p-2">
                            <Input v-model="commentData" type="textarea" :placeholder="$t('placeholder').enterComment" />
                            <div class="d-flex justify-content-between col-12 p-0">
                                <Icon @click="toggleEmo" class="pr-2 noti-upload-icons" size="25" type="md-happy" />
                                <div class="emoji-area-popup">
                                    <div v-if="emoStatus" class="position-absolute close-emoji-btn" @click="closeEmojiWindow()">{{$t('common').closeEmoji}}</div>
                                    <Picker v-if="emoStatus" set="emojione" @select="onInput" title="Pick your emoji..." />
                                </div>
                                <Button @click="leaveComment">{{$t('community').Leave}}</Button>
                            </div>
                        </div>
                    </div>
                    <div v-for="(comment,i) in commentsOfCurrentSuggestion" :key="i" v-if="commentsOfCurrentSuggestion.length"  class="posted-item row m-0 p-3 mt-3">
                        <div class="col-1">
                            <div class="posted-item-user-info">
                                <img :src="`${baseUrl}${comment.user_id.user_avatar}`" class="rounded-circle profile-photo mr-1" alt="">
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
                            <div v-if="comment.user_id.id == currentUser.id && comment.isRemoved == 0" class="remove-comment">
                                <Poptip
                                    class="float-right"
                                    confirm
                                    title="Are you sure you want to delete this comment?"
                                    ok-text="Yes"
                                    cancel-text="Cancel"
                                    placement="left"
                                    @on-ok="removeComment(comment)"
                                    @on-cancel="cancelRemoveComment">
                                    <Icon size="25" class="float-right" type="md-trash"/>
                                </Poptip>
                            </div>
                        </div>  
                    </div>
                    <InfiniteLoading 
                        class="p-3"
                        @infinite="infiniteHandlerComments"
                        spinner="circles"
                    >
                        <div slot="no-more">{{$t('infinitLoader').commentNoMore}}</div>
                        <div slot="no-results" class="position-relative row m-0 p-2 h-50 d-flex justify-content-center align-items-center">
                            <div class="no-fac text-center p-5 m-5">
                                <h5>{{ $t('infinitLoader').commentNoResult }}</h5>
                            </div>
                        </div>
                    </InfiniteLoading>
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
import InfiniteLoading from 'vue-infinite-loading'
//import Apis
import {
    viewCurrentSuggestion, 
    getCommentsOfCurrentSuggestion, 
    leaveCommentToSuggestion, 
    getCurrentSuggestionFromServer, 
    heartToSuggestion, 
    unHeartToSuggestion, 
    likeToSuggestion, 
    dislikeToSuggestion, 
    unLikeToSuggestion, 
    unDislikeToSuggestion,
    deleteSuggestion,
    deleteComment,
    getFirstItem,
    getLastItem,
    getPreviousItem,
    getNextItem
} from '~/api/suggestion'

import Category from './category'

import { mapGetters } from 'vuex'
import i18n from '~/plugins/i18n'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').viewDetailSuggestion }
    },

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
            heart_mine:false,
            like_mine:false,
            dislike_mine:false,
            details:null,
            suggestionId:null,
            playerOptionsGroup:[],
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
            },

            //comment
            isCommenting:false,
            commentData:null,
            //emoji
            emoStatus:false,
            commentsOfCurrentSuggestion:[],
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
        this.suggestionId = this.currentPath.params.id;
        this.getCurrentSuggestion();
    },
    mounted(){
    },
    methods:{

        getPreviousItem(){
            getPreviousItem(this.suggestionId)
            .then(res=>{
                if(res.data == ""){
                    return this.error(i18n.t('alert').first);
                }
                this.$router.push({ path:`/suggestion/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },
        
        getNextItem(){
            getNextItem(this.suggestionId)
            .then(res=>{
                if(res.data == ""){
                    return this.error(i18n.t('alert').last);
                }
                this.$router.push({ path:`/suggestion/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },

        getFirstItem(){
            getFirstItem()
            .then(res=>{
                this.$router.push({ path:`/suggestion/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },

        getLastItem(){
            getLastItem()
            .then(res=>{
                this.$router.push({ path:`/suggestion/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },

        editSuggestion(suggestion){
            if(suggestion.comment_cnt == null ){
                this.$router.push({name:'suggestion.update',params:{updateSuggestionData:suggestion}})
            }
            else{
                return this.error(i18n.t('alert').cannotUpdate);
            }
        },

        async leaveComment(){
            if(this.commentData == null){
                return this.error(i18n.t('alert').comment);
            }
            await leaveCommentToSuggestion(this.commentData, this.details)
            .then(res=>{
                let commentCurrently = res.data.commentToSuggest;
                commentCurrently['created_at'] = Date.now();
                commentCurrently['user_id'] = {};
                commentCurrently.user_id['name'] = this.currentUser.name;
                commentCurrently.user_id['user_avatar'] = this.currentUser.user_avatar;
                commentCurrently.user_id['id'] = this.currentUser.id;
                this.commentData = null;
                this.commentsOfCurrentSuggestion.unshift(commentCurrently);
                if(this.details.comment_cnt == null) {
                    this.details.comment_cnt = [];
                    this.details.comment_cnt.push(this.currentUser.id);
                }
                else{
                    this.details.comment_cnt.push(this.currentUser.id);
                }
                this.isCommenting = false;
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

        getCurrentSuggestion(){
            getCurrentSuggestionFromServer(this.suggestionId)
            .then(res=>{
                this.details = res.data.suggestionData;
                this.details.heart_cnt = JSON.parse(this.details.heart_cnt);
                this.details.like_cnt = JSON.parse(this.details.like_cnt);
                this.details.dislike_cnt = JSON.parse(this.details.dislike_cnt);
                this.details.upload_file = JSON.parse(this.details.upload_file);
                this.details.comment_cnt = JSON.parse(this.details.comment_cnt);
                //video url
                let videoUrlGroup = this.details.upload_file.videoUrl;
                for(let i = 0; i < videoUrlGroup.length ; i++){
                    let clonedOption = JSON.parse(JSON.stringify(this.playerOptions));
                    clonedOption.sources[0].src = this.baseUrl + '/uploads/video/'+videoUrlGroup[i].fileName;
                    this.playerOptionsGroup.push(clonedOption);
                }
                viewCurrentSuggestion(this.details.id);
            })
        },

        infiniteHandlerComments($state){
            let timeOut = 0;
            
            if (this.pageOfComments > 1) {
                timeOut = 2000;
            }
            let vm = this;
            setTimeout(() => {
                getCommentsOfCurrentSuggestion(this.pageOfComments, this.suggestionId)
                .then(res=>{
                    vm.lastpageOfComments = res.data.last_page;

                    $.each(res.data.data, function(key, value){
                        vm.commentsOfCurrentSuggestion.push(value);
                    });
                    if (vm.pageOfComments - 1 === vm.lastpageOfComments) {
                        $state.complete();
                    }
                    else {
                        $state.loaded();
                    }
                    vm.pageOfComments = vm.pageOfComments + 1;
                }); 
            }, 2000);
            
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

        removeSuggestion(){
            this.details.upload_file = {
                imgUrl: [],
                otherUrl: [],
                videoUrl: [],
            }
            deleteSuggestion(this.details)
            .then(res=>{
                if(res.status == 200){
                    this.success(i18n.t('alert').removeSuccessfully);
                    this.$router.push({name:'suggestion.list'});
                }
            })
            .catch(err=>{
                console.log(err);
            })
        },

        cancelRemoveSuggestion(){
        },
        removeComment(comment){
            deleteComment(comment)
            .then(res=>{
                if(res.status == 200){
                    this.success(i18n.t('alert').removeSuccessfully);
                    comment.isRemoved = 1;
                    comment.content = "removed by author"
                }
            })
            .catch(err=>{
                console.log(err);
            })
        },

        cancelRemoveComment(){
        },
    }
}
</script>

<style scoped>
    .center{
        width: 300px;
        margin: 10px auto;
        overflow: hidden;
    }
</style>