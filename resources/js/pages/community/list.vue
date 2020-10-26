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
                    <div class="posted-item" v-for="(notification,i) in notificationList" :key="i" v-if="notificationList.length">
                        <div class="pi-wrap float-left">
                            <div class="user-info float-left">
                                <div class="avatar">
                                    <Avatar icon="ios-person" size="large" />
                                </div>
                                <div class="icons">
                                    <Icon size="25px" color="#BDC3C7" type="logo-android" />
                                    <Icon size="25px" color="#BDC3C7" type="logo-android" />
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
                    </div>
                    <InfiniteLoading 
                        class="pb-3"
                        @infinite="infiniteHandlerNotification"
                        spinner="circles"
                    >
                        <div slot="no-more">no more notification</div>
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
import {getNotificationList,registerNotification,updateNotification,delNotification} from '~/api/notification'
export default {
    components:{
        InfiniteLoading,
    },
    data(){
        return{
            notificationList : [],

            //infinit loading
            pageOfNotification: 1,
            lastPageOfNotification: 0,
        }
    },

    async created(){
        // this.start();
    },

    methods:{
        async start(){
            await getNotificationList()
            .then(res=>{
                console.log(res);
            })
        },

        async infiniteHandlerNotification($state){
            console.log("something")
            let timeOut = 0;
            
            if (this.pageOfNotification > 1) {
                timeOut = 1000;
            }
            let vm = this;
            await getNotificationList(this.pageOfNotification)
            .then(res=>{
                console.log(res);
                vm.lastpageOfNotification = res.data.last_page;

                $.each(res.data.data, function(key, value){
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