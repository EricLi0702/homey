<template>
    <div>
        <!-- <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 py-5 bg-white">
                <p>something...</p>
            </div>
        </div> -->
        <div class="container m-0 p-0 mx-auto">
            <div class="row m-0 p-0">
                <Category/>
                <div class="col-12 col-md-8 m-0 p-0">
                    <div v-if="noSuggestion" class="position-relative row m-0 p-2 h-50 d-flex justify-content-center align-items-center">
                        <div class="no-fac text-center">
                            <Icon size="150" type="ios-search" />
                            <h5>{{ $t('suggest').oopsNoSuggestion }}</h5>
                        </div>
                    </div>
                    <div v-else-if="suggestionList.length" class="posted-item position-relative" v-for="(suggestion,i) in suggestionList" :key="i" >
                        <router-link :to="{path:`/suggestion/${suggestion.id}`}">
                            
                            <div class="pi-wrap float-left ">
                                <div class="user-info float-left">
                                    <div class="avatar">
                                        <img :src="`${baseUrl}${suggestion.user_id.user_avatar}`" class="rounded-circle profile-photo mr-1" alt="">
                                    </div>
                                    <div class="icons text-center">
                                        <p>{{suggestion.id}}</p>
                                    </div>
                                </div>
                                <div class="post-text float-left">
                                    <h2>
                                        {{suggestion.title}}
                                    </h2>
                                    <p v-html="suggestion.content"></p>
                                    <div class="cnt d-flex position-absolute">
                                        <div class="heart d-flex mr-4">
                                            <Icon class="mr-1" size="25" type="md-heart-outline" />
                                            <span v-if="suggestion.heart_cnt !== null">{{suggestion.heart_cnt.length}}</span>
                                            <span v-else>0</span>
                                        </div>
                                        <div class="like d-flex mr-4">
                                            <Icon class="mr-1" size="25" type="md-thumbs-up" />
                                            <span v-if="suggestion.like_cnt !== null">{{suggestion.like_cnt.length}}</span>
                                            <span v-else>0</span>
                                        </div>
                                        <div class="dislike d-flex">
                                            <Icon class="mr-1" size="25" type="md-thumbs-down" />
                                            <span v-if="suggestion.dislike_cnt !== null">{{suggestion.dislike_cnt.length}}</span>
                                            <span v-else>0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="posted-item-info float-left">
                                <div class="posted-item-info-comments">
                                    <div class="pii-commentbg">
                                        <span v-if="suggestion.comment_cnt !== null">{{suggestion.comment_cnt.length}}</span>
                                        <span v-else>0</span>
                                        <div class="mark">

                                        </div>
                                    </div>
                                </div>
                                <div class="posted-item-info-views">
                                    <Icon type="md-eye" />
                                    <span v-if="suggestion.view_cnt !== null">{{suggestion.view_cnt.length}}</span>
                                    <span v-else>0</span>
                                </div>
                                <div class="posted-item-info-time">
                                    <Icon type="ios-clock-outline" />
                                    <timeago :datetime="suggestion.updated_at" :since="suggestion.updated_at" :auto-update="60"></timeago>
                                </div>
                            </div>
                            <div class="clearfix">
                                
                            </div>
                        </router-link>
                    </div>
                    <InfiniteLoading 
                        class="p-3"
                        @infinite="infiniteHandlerSuggestion"
                        spinner="circles"
                    >
                        <div slot="no-more">{{ $t('suggest').noMoreSuggestion }}</div>
                    </InfiniteLoading>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
//infinitLoding
import InfiniteLoading from 'vue-infinite-loading';
import {getSuggestionList,registerSuggestion,updateSuggestion,delSuggestion} from '~/api/suggestion'
import Category from './category'
// import VueTimeago from 'vue-timeago'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').suggestionList }
    },
    components:{
        InfiniteLoading,
        Category,
        // VueTimeago
    },
    data(){
        return{
            baseUrl:window.base_url,
            suggestionList : [],
            noSuggestion:false,
            //infinit loading
            pageOfSuggestion: 1,
            lastPageOfSuggestion: 0,
        }
    },

    async created(){
        // this.start();
    },

    methods:{
        async start(){
            await getSuggestionList()
            .then(res=>{
                console.log(res);
            })
        },

        async infiniteHandlerSuggestion($state){
            let timeOut = 0;
            
            if (this.pageOfSuggestion > 1) {
                timeOut = 1000;
            }
            let vm = this;
            await getSuggestionList(this.pageOfSuggestion)
            .then(res=>{
                if(vm.pageOfSuggestion == 1 && res.data.data.length == 0){
                    this.noSuggestion = true;
                    $state.complete();
                    return;
                }
                vm.lastpageOfSuggestion = res.data.last_page;

                $.each(res.data.data, function(key, value){
                        value.heart_cnt = JSON.parse(value.heart_cnt);
                        value.like_cnt = JSON.parse(value.like_cnt);
                        value.dislike_cnt = JSON.parse(value.dislike_cnt);
                        value.comment_cnt = JSON.parse(value.comment_cnt);
                        value.view_cnt = JSON.parse(value.view_cnt);
                        vm.suggestionList.push(value); 
                    });
                if (vm.pageOfSuggestion - 1 === vm.lastpageOfSuggestion) {
                    $state.complete();
                }
                else {
                    $state.loaded();
                }
                vm.pageOfSuggestion = vm.pageOfSuggestion + 1;
            });
             
                
        },

        listenNewNotification(){
            Echo.private('notification')
                .listen('NewNotification', (newNotification) => {
                    console.log("wow, greate!!",newNotification);
                    // this.$store.commit('setNewNotificationCnt', this.getCurrentUser.new_noti_cnt + 1);
                    // this.notificationList.unshift(newNotification.notification);
                    // Notification.requestPermission( permission => {
                    //     let notification = new Notification('New post alert!', {
                    //         body: newNotification.notification.title, // content for the alert
                    //         icon: "http://127.0.0.1:8000/images/icons/mainPage-phone.png" // optional image url
                    //     });

                    //     // link to page on clicking the notification
                    //     notification.onclick = () => {
                    //         window.open(window.location.href);
                    //     };
                    // });
                    // const res = this.callApi('post','/api/users/newVideoCount',{new_video_cnt:this.$store.state.user.new_video_cnt});
                });
        },
    }
}
</script>