<template>
    <div class="container m-0 p-0 mx-auto">
        <div class="row m-0 p-0">
            <Category/>
            <div class="col-12 col-md-8 m-0 p-0 pb-3">
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
                    <div class="offset-1 col-11 d-flex">
                        <div v-if="details.isRemoved == 0" class="d-flex w-100">
                            <div v-if="currentUser.id == details.userId || currentUser.roleId == 2" class="remove-community mr-auto">
                                <Poptip
                                    confirm
                                    title="Are you sure you want to delete this Topic?"
                                    ok-text="Yes"
                                    cancel-text="Cancel"
                                    placement="right"
                                    @on-ok="removeCommunity"
                                    @on-cancel="cancelRemoveCommunity">
                                    <Icon size="25" class="mr-4" type="md-trash"/>
                                </Poptip>
                                <Icon @click="editCommunity(details)" size="25" class="mr-4" type="md-create"/>
                            </div>
                            <div v-else class="reply mr-auto">
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
                <div v-if="isCommenting" class="posted-item mt-3 p-2 animate__animated animate__fadeIn">
                    <div class="reply-form-comment row p-2">
                        <Input v-model="commentData" type="textarea" :placeholder="$t('placeholder').enterComment" />
                        <div class="d-flex justify-content-between col-12 p-0">
                            <Icon @click="toggleEmo" class="pr-2 noti-upload-icons" size="25" type="md-happy" />
                            <div class="emoji-area-popup">
                                <div v-if="emoStatus" class="position-absolute close-emoji-btn" @click="closeEmojiWindow()">{{$t('common').closeEmoji}}</div>
                                <Picker v-if="emoStatus" set="emojione" @select="onInput" title="Pick your emoji..." />
                            </div>
                            <Button :disabled="isLeaving" :loading="isLeaving" @click="leaveComment">{{ $t('community').Leave }}</Button>
                        </div>
                    </div>
                </div>
                
                <div 
                v-for="(comment,i) in commentsOfCurrentCommunity" 
                :key="i" 
                v-if="commentsOfCurrentCommunity.length"  
                class="posted-item row m-0 p-3 mt-3 comment-item" 
                :style="`margin-left:${comment.lvl * 50}px!important;`"
                >
                    <div class="col-1 p-0">
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
                        <div v-if="comment.isRemoved ==0 " >
                            <div v-if="comment.user_id.id == currentUser.id" class="remove-comment">
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
                            <div v-else class="reply-comment">
                                <Icon @click="toggleReplyToComment(comment)" size="25" class="float-right" type="ios-share-alt"/>
                            </div>
                        </div>
                        

                    </div>  
                    <div v-if="comment.showReply" class="col-12 animate__animated animate__fadeIn" >
                        <div class="reply-form-comment row p-2">
                            <Input v-model="replyToCommentData" type="textarea" :placeholder="$t('placeholder').enterComment" />
                            <div class="d-flex justify-content-between col-12 p-0">
                                <Icon @click="toggleEmoOfReply" class="pr-2 noti-upload-icons" size="25" type="md-happy" />
                                <div class="emoji-area-popup">
                                    <Picker v-if="emoStatusOfReply" set="emojione" @select="onInputOfReply" title="Pick your emoji..." />
                                </div>
                                <Button :disabled="isReplyToCommentBtn" :loading="isReplyToCommentBtn" @click="replyToComment(comment)">{{ $t('community').reply }}</Button>
                            </div>
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
import { mapGetters } from 'vuex'
import Category from './category'
import {
    viewCurrentCommunity, 
    getCommentsOfCurrentCommunity, 
    leaveCommentToCommunity, 
    getCurrentCommunityFromServer, 
    deleteCommunity,
    deleteComment,
    replyToComment,
    getFirstItem,
    getLastItem,
    getPreviousItem,
    getNextItem
} from '~/api/community'
import i18n from '~/plugins/i18n'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').viewDetailCommunity }
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
            isCommenting: false,
            isLeaving:false,
            commentData:null,
            emoStatus:false,
            commentsOfCurrentCommunity:[],

            details:null,
            communityId:null,
            baseUrl:window.base_url,
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
                // poster: "/static/images/author.jpg",
            },

            //infinit loading
            pageOfComments: 1,
            lastPageOfComments: 0,

            isOpenReplyToComment:false,
            replyToCommentData:'',
            emoStatusOfReply:false,
            isReplyToCommentBtn: false,
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
        this.communityId = this.currentPath.params.id;
        this.getCurrentCommunity();
    },

    mounted(){
        
    },

    methods:{
        getPreviousItem(){
            getPreviousItem(this.communityId)
            .then(res=>{
                if(res.data == ""){
                    return this.error(i18n.t('alert').first);
                }
                this.$router.push({ path:`/community/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },
        
        getNextItem(){
            getNextItem(this.communityId)
            .then(res=>{
                if(res.data == ""){
                    return this.error(i18n.t('alert').last);
                }
                this.$router.push({ path:`/community/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },

        getFirstItem(){
            getFirstItem()
            .then(res=>{
                this.$router.push({ path:`/community/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },

        getLastItem(){
            getLastItem()
            .then(res=>{
                this.$router.push({ path:`/community/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },

        editCommunity(community){
            if(community.comment_cnt == null ){
                this.$router.push({name:'community.update',params:{updateCommunityData:community}})
            }
            else{
                return this.error(i18n.t('alert').cannotUpdate);
            }
        },

        getCurrentCommunity(){
            getCurrentCommunityFromServer(this.communityId)
            .then(res=>{
                this.details = res.data.communityData;
                this.details.upload_file = JSON.parse(this.details.upload_file);
                this.details.comment_cnt = JSON.parse(this.details.comment_cnt);
                //video url
                let videoUrlGroup = this.details.upload_file.videoUrl;
                for(let i = 0; i < videoUrlGroup.length ; i++){
                    let clonedOption = JSON.parse(JSON.stringify(this.playerOptions));
                    clonedOption.sources[0].src = this.baseUrl + '/uploads/video/'+videoUrlGroup[i].fileName;
                    this.playerOptionsGroup.push(clonedOption);
                }
                viewCurrentCommunity(this.details.id);
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

        toggleEmoOfReply(){
            this.emoStatusOfReply = !this.emoStatusOfReply;
        },

        onInputOfReply(e){
            if(!e){
                return false;
            }
            if(!this.replyToCommentData){
                this.replyToCommentData = e.native
            }else{
                this.replyToCommentData = this.replyToCommentData + e.native
            }
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

        removeCommunity(){
            this.details.upload_file = {
                imgUrl: [],
                otherUrl: [],
                videoUrl: [],
            }
            deleteCommunity(this.details)
            .then(res=>{
                if(res.status == 200){
                    this.success(i18n.t('alert').removeSuccessfully);
                    this.$router.push({name:'community.list'});
                }
            })
            .catch(err=>{
                console.log(err);
            })
        },

        cancelRemoveCommunity(){
        },

        async leaveComment(){
            if(this.commentData == null){
                return this.error(i18n.t('alert').comment);
            }
            this.isLeaving = true;
            await leaveCommentToCommunity(this.commentData, this.details)
            .then(res=>{
                this.isLeaving = false;
                let commentCurrently = res.data.commentToCommunity;
                commentCurrently['created_at'] = Date.now();
                commentCurrently['user_id'] = {};
                commentCurrently['isRemoved'] = 0;
                commentCurrently.user_id['name'] = this.currentUser.name;
                commentCurrently.user_id['user_avatar'] = this.currentUser.user_avatar;
                commentCurrently.user_id['id'] = this.currentUser.id;
                this.commentData = null;
                this.commentsOfCurrentCommunity.unshift(commentCurrently);
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

        infiniteHandlerComments($state){
            let timeOut = 0;
            
            if (this.pageOfComments > 1) {
                timeOut = 2000;
            }
            let vm = this;
            setTimeout(() => {
                getCommentsOfCurrentCommunity(this.pageOfComments, this.communityId)
                .then(res=>{
                    vm.lastpageOfComments = res.data.last_page;

                    $.each(res.data.data, function(key, value){
                        value['showReply'] = false;
                        vm.commentsOfCurrentCommunity.push(value);
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

        toggleReplyToComment(comment){
            for(let i = 0; i < this.commentsOfCurrentCommunity.length; i++ ){
                if(this.commentsOfCurrentCommunity[i].showReply == true && this.commentsOfCurrentCommunity[i].id !== comment.id){
                    this.replyToCommentData = '';
                    this.emoStatusOfReply = false;
                    this.commentsOfCurrentCommunity[i].showReply = false;
                }
            }
            if(comment.showReply == true){
                this.replyToCommentData = '';
                this.emoStatusOfReply = false;
                comment.showReply = false;
            }
            else if(comment.showReply == false){
                comment.showReply = true;
            }
        },

        replyToComment(comment){
            if(this.replyToCommentData.trim() == ''){
                return this.error(i18n.t('alert').comment);
            }
            let replyToCommentPayload = {};
            replyToCommentPayload.parentComment = comment;
            replyToCommentPayload.childCommentContent = this.replyToCommentData;
            replyToComment(replyToCommentPayload)
            .then(res=>{
                let resData = res.data.replyToCommentData;
                resData['created_at'] = Date.now();
                resData['user_id'] = {};
                resData['isRemoved'] = 0;
                resData.user_id['name'] = this.currentUser.name;
                resData.user_id['user_avatar'] = this.currentUser.user_avatar;
                resData.user_id['id'] = this.currentUser.id;
                this.replyToCommentData = null;
                this.emoStatusOfReply = false;
                comment.showReply = false;
                let replyOfParentId;
                for(let i = 0; i < this.commentsOfCurrentCommunity.length; i++){
                    if( resData.parentId == this.commentsOfCurrentCommunity[i].parentId){
                        replyOfParentId = i;
                        break;
                    }
                }
                replyOfParentId = replyOfParentId + 1;
                this.commentsOfCurrentCommunity.splice(replyOfParentId + resData.seq - 1, 0, resData);
            })
            .catch(err=>{
                console.log(err);
            })
        }
    }

    

}
</script>