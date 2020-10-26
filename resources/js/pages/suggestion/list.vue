<template>
    <div>
        <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 py-5 bg-white">
                <p>something...</p>
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
                <div class="col-12 col-md-8 m-0 p-0">
                    <div class="posted-item" v-for="(suggestion,i) in suggestionList" :key="i" v-if="suggestionList.length">
                        <router-link :to="{path:`/suggestion/${suggestion.id}`}">
                            
                            <div class="pi-wrap float-left position-relative">
                                <div class="user-info float-left">
                                    <div class="avatar">
                                        <Avatar icon="ios-person" size="large" />
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
                                        44
                                        <div class="mark">

                                        </div>
                                    </div>
                                </div>
                                <div class="posted-item-info-views">
                                <Icon type="md-eye" />
                                    3452 
                                </div>
                                <div class="posted-item-info-time">
                                    <Icon type="ios-clock-outline" />
                                    15 min
                                </div>
                            </div>
                            <div class="clearfix">
                                
                            </div>
                        </router-link>
                    </div>
                    <InfiniteLoading 
                        class="pb-3"
                        @infinite="infiniteHandlerSuggestion"
                        spinner="circles"
                    >
                        <div slot="no-more">no more suggestion</div>
                    </InfiniteLoading>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
//infinitLoding
import InfiniteLoading from 'vue-infinite-loading';
import axios from 'axios'
import {getSuggestionList,registerSuggestion,updateSuggestion,delSuggestion} from '~/api/suggestion'
export default {
    components:{
        InfiniteLoading,
    },
    data(){
        return{
            suggestionList : [],

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
            console.log("something")
            let timeOut = 0;
            
            if (this.pageOfSuggestion > 1) {
                timeOut = 1000;
            }
            let vm = this;
            await getSuggestionList(this.pageOfSuggestion)
            .then(res=>{
                console.log(res);
                vm.lastpageOfSuggestion = res.data.last_page;

                $.each(res.data.data, function(key, value){
                        value.heart_cnt = JSON.parse(value.heart_cnt);
                        value.like_cnt = JSON.parse(value.like_cnt);
                        value.dislike_cnt = JSON.parse(value.dislike_cnt);
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