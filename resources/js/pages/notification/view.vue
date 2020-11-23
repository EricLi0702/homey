<template>
    <div class="container m-0 p-0 mx-auto">
        <div class="row m-0 p-0">
            <Category/>
            <div class="col-12 col-md-8 m-0 p-0 pb-4">
                <div v-if="details !== null && ( currentUser.roleId == 2 || currentUser.roleId == 6 || currentUser.roleId == 1)" class="control-notification row m-0 mb-3 d-flex justify-content-between">
                    <Button @click="editNotification(details)" icon="md-create" type="info">{{$t('notification').update}}</Button>
                    <Poptip
                        class="ml-auto mr-2"
                        confirm
                        title="Are you sure remove this notification?"
                        ok-text="Yes"
                        cancel-text="Cancel"
                        placement="bottom"
                        @on-ok="deleteNotification"
                        @on-cancel="cancelDeleteNotification">
                        <Button icon="md-trash" type="error" :loading="isDeleting" :disabled="isDeleting">{{$t('notification').Remove}}</Button>
                    </Poptip>
                    <Poptip
                        v-if="details.isDowngrade == 0"
                        confirm
                        title="Are you sure downgrade this notification?"
                        ok-text="Yes"
                        cancel-text="Cancel"
                        placement="bottom"
                        @on-ok="downgradeNotification"
                        @on-cancel="cancelDowngradeNotification">
                        <Button icon="md-trending-down" type="warning">{{$t('notification').DownGrade}}</Button>
                    </Poptip>
                    <Poptip
                        v-if="details.isDowngrade == 1"
                        confirm
                        title="Are you sure upgrade this notification?"
                        ok-text="Yes"
                        cancel-text="Cancel"
                        placement="bottom"
                        @on-ok="upgradeNotification"
                        @on-cancel="cancelUpgradeNotification">
                        <Button icon="md-trending-up" type="success">{{$t('notification').UpGrade}}</Button>
                    </Poptip>
                </div>
                <div v-if="details !== null" class="posted-item row m-0 p-2 py-3">
                    <div class="col-2">
                        <div class="posted-item-user-info">
                            <img :src="`${baseUrl}${details.user_id.user_avatar}`" class="rounded-circle profile-photo mr-1" alt="">
                        </div>
                        <div class="icons">
                            <Icon v-if="details.type == 0" size="21" type="md-hand" color="#BFD23A"/>
                            <Icon v-else-if="details.type == 1" size="21" type="md-stopwatch" color="#F4B894" />
                            <Icon v-else-if="details.type == 2" size="21" type="ios-warning-outline" color="#F26A5A" />
                            <div v-else-if="details.type == 3">
                                <Icon size="21" type="md-stopwatch" color="#F4B894" />
                                <Icon size="21" type="ios-warning-outline" color="#F26A5A" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-10">
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
                </div>
                <div v-if="details !== null" class="navigte-item d-flex justify-content-center mt-3">
                    <ButtonGroup shape="circle">
                        <Button @click="getFirstItem" type="primary" icon="ios-skip-backward"></Button>
                        <Button @click="getPreviousItem" type="primary" icon="md-arrow-round-back"></Button>
                        <Button @click="getNextItem" type="primary" icon="md-arrow-round-forward"></Button>
                        <Button @click="getLastItem" type="primary" icon="ios-skip-forward"></Button>
                    </ButtonGroup>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

//image viewer
import 'viewerjs/dist/viewer.css'
import Viewer from 'v-viewer'
//video viewer
import 'video.js/dist/video-js.css'
import { videoPlayer } from 'vue-video-player'
import Category from './category'
import { mapGetters } from 'vuex'
import i18n from '~/plugins/i18n'
import {
    getCurrentNotificationFromServer, 
    viewedCurrentNotification, 
    downgradeNotification, 
    upgradeNotification,
    deleteNotification,
    getFirstItem,
    getLastItem,
    getPreviousItem,
    getNextItem
} from '~/api/notification'

export default {
    metaInfo () {
        return { title: this.$t('metaInfo').viewDetailNotification }
    },
    middleware: 'auth',
    components:{
        Viewer,
        videoPlayer,
        Category
    },

    data(){
        return{
            baseUrl:window.base_url,
            details:null,
            notificationId:null,
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
            isDeleting:false,
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
        this.notificationId = this.currentPath.params.id;
        this.getCurrentNotification();
    },

    methods:{
        getPreviousItem(){
            getPreviousItem(this.notificationId)
            .then(res=>{
                if(res.data == ""){
                    return this.error(i18n.t('alert').first);
                }
                this.$router.push({ path:`/notification/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },
        
        getNextItem(){
            getNextItem(this.notificationId)
            .then(res=>{
                if(res.data == ""){
                    return this.error(i18n.t('alert').last);
                }
                this.$router.push({ path:`/notification/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },

        getFirstItem(){
            getFirstItem()
            .then(res=>{
                this.$router.push({ path:`/notification/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },

        getLastItem(){
            getLastItem()
            .then(res=>{
                this.$router.push({ path:`/notification/${res.data.id}` });
            })
            .catch(err=>{
                console.log(err);
            })
        },

        editNotification(notification){
            this.$router.push({name:'notification.update',params:{updateNotificationData:notification}})
        },

        showImage(){
            const viewer = this.$el.getElementsByClassName('post-img-item').$viewer
            viewer.show()
        },

        getCurrentNotification(){
            getCurrentNotificationFromServer(this.notificationId)
            .then(res=>{
                this.details = res.data.notificationData;
                this.details.upload_file = JSON.parse(this.details.upload_file);
                //video url
                let videoUrlGroup = this.details.upload_file.videoUrl;
                for(let i = 0; i < videoUrlGroup.length ; i++){
                    let clonedOption = JSON.parse(JSON.stringify(this.playerOptions));
                    clonedOption.sources[0].src = this.baseUrl + '/uploads/video/'+videoUrlGroup[i].fileName;
                    this.playerOptionsGroup.push(clonedOption);
                }

                viewedCurrentNotification(this.details.id);
            })
        },

        downgradeNotification(){
            downgradeNotification(this.details)
            .then(res=>{
                if(res.status == 200){
                    this.success(i18n.t('alert').downgrade);
                    this.$router.push({name:'notification.list'});
                }
            })
            .catch(err=>{
                console.log(err);
            })
        },

        cancelDowngradeNotification(){
        },

        upgradeNotification(){
            upgradeNotification(this.details)
            .then(res=>{
                if(res.status == 200){
                    this.success(i18n.t('alert').upgrade);
                    this.$router.push({name:'notification.list'});
                }
            })
            .catch(err=>{
                console.log(err);
            })
        },

        cancelUpgradeNotification(){
        },

        deleteNotification(){
            this.isDeleting = true;
            deleteNotification(this.details)
            .then(res=>{
                if(res.status == 200){

                    this.success(i18n.t('alert').removeSuccessfully);
                    this.$router.push({name:'notification.list'});
                }
            })
            .catch(err=>{
                console.log(err);
            })
            
            this.isDeleting = false;
        },

        cancelDeleteNotification(){
            
        },

    }
}
</script>