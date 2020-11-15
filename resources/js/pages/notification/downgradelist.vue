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
                    <div v-if="notificationList.length == 0" class="position-relative row m-0 p-2 h-50 d-flex justify-content-center align-items-center">
                        <div class="no-fac text-center">
                            <Icon size="150" type="ios-search" />
                            <h5>oops! there is no downgraded notification!</h5>
                        </div>
                    </div>
                    <div v-else-if="notificationList.length" class="posted-item" v-for="(notification,i) in notificationList" :key="i" >
                        <router-link :to="{path:`/notification/${notification.id}`}">
                            <div class="pi-wrap float-left">
                                <div class="user-info float-left">
                                    <div class="avatar">
                                        <img :src="`${baseUrl}${notification.user_id.user_avatar}`" class="rounded-circle profile-photo mr-1" alt="">
                                    </div>
                                    <div class="icons text-center">
                                        <Icon v-if="checkIfViewed(notification.view_cnt)" type="md-done-all" size="30" color="#0F4C81" />
                                        <Icon v-else type="ios-close-circle-outline" size="30" color="#0F4C81" />
                                    </div>
                                </div>
                                <div class="post-text float-left">
                                    <h2>
                                        <a href="#">{{notification.title}}</a>
                                    </h2>
                                    <p v-html="notification.content"></p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="posted-item-info float-left">
                                <div class="posted-item-info-comments row m-0">
                                    <div class="col-6 p-0">
                                        <Icon v-if="notification.type.includes('common')" size="30" type="md-hand" color="#BFD23A"/>
                                    </div>
                                    <div class="col-6 p-0">
                                        <Icon v-if="notification.type.includes('urgent')" size="30" type="md-stopwatch" color="#F4B894" />
                                    </div>
                                    <div class="col-6 p-0">
                                        <Icon v-if="notification.type.includes('important')" size="30" type="ios-warning-outline" color="#F26A5A" />
                                    </div>
                                </div>
                                <div class="posted-item-info-views">
                                    <Icon type="md-eye" />
                                    <span v-if="notification.view_cnt !== null">{{notification.view_cnt.length}}</span>
                                    <span v-else>0</span>
                                </div>
                                <div class="posted-item-info-time">
                                    <Icon type="ios-clock-outline" />
                                    <timeago :datetime="notification.updated_at" :since="notification.updated_at" :auto-update="60"></timeago>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </router-link>
                    </div>
                    <InfiniteLoading
                        v-if="notificationList.length !== 0" 
                        class="pb-3"
                        @infinite="infiniteHandlerNotification"
                        spinner="circles"
                    >
                    
                        <div slot="no-more">no more notification{{$t('facility').CalendarView}}</div>
                    </InfiniteLoading>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
//infinitLoding
import InfiniteLoading from 'vue-infinite-loading';
import {getDowngradNotificationList,registerNotification,updateNotification,delNotification} from '~/api/notification'
import Category from './category'
import { mapGetters } from 'vuex'
export default {

    components:{
        InfiniteLoading,
        Category,
    },
    data(){
        return{
            notificationList : [],
            baseUrl:window.base_url,
            //infinit loading
            pageOfNotification: 1,
            lastPageOfNotification: 0,
        }
    },

    computed:{ 
        ...mapGetters({
            currentUser: 'auth/user'
        }),
    },

    async created(){
        // this.start();
    },

    methods:{
        async start(){
            await getDowngradNotificationList()
            .then(res=>{
                console.log(res);
            })
        },

        async infiniteHandlerNotification($state){
            let timeOut = 0;
            
            if (this.pageOfNotification > 1) {
                timeOut = 1000;
            }
            let vm = this;
            await getDowngradNotificationList(this.pageOfNotification)
            .then(res=>{
                vm.lastpageOfNotification = res.data.last_page;

                $.each(res.data.data, function(key, value){
                        value.view_cnt = JSON.parse(value.view_cnt);
                        vm.notificationList.push(value); 
                    });
                if (vm.pageOfNotification - 1 === vm.lastpageOfNotification) {
                    $state.complete();
                }
                else {
                    $state.loaded();
                }
                vm.pageOfNotification = vm.pageOfNotification + 1;
            });
        },
        
        checkIfViewed(viewCntArray){
            if (viewCntArray == null){
                return false;
            }
            else{
                let userId = this.currentUser.id;
                for( let i = 0; i < viewCntArray.length ; i++){
                    if(viewCntArray[i] == userId){
                        return true;
                    }
                }
                return false;
            }
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