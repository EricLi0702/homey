<template>
    <div>
        <div class="container m-0 p-0 mx-auto">
            <div class="row m-0 p-0">
                <Category />
                <div class="col-12 col-md-8 m-0 p-0">
                    <div class="posted-item" v-for="(notification,i) in notificationList" :key="i" v-if="notificationList.length">
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
                                <div>
                                    <Button type="success" icon="md-trending-up" @click="upgradeNotification(notification)">{{$t('notification').UpGraded}}</Button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="posted-item-info float-left">
                            <div class="posted-item-info-comments row m-0">
                                <div v-if="notification.type == 0" class="col-12 p-0">
                                    <Icon size="30" type="md-hand" color="#BFD23A"/>
                                </div>
                                <div v-else-if="notification.type == 1" class="col-12 p-0">
                                    <Icon size="30" type="md-stopwatch" color="#F4B894" />
                                </div>
                                <div v-else-if="notification.type == 2" class="col-12 p-0">
                                    <Icon size="30" type="ios-warning-outline" color="#F26A5A" />
                                </div>
                                <div v-else-if="notification.type == 3" class="col-12 p-0 row m-0">
                                    <div class="col-6">
                                        <Icon size="30" type="md-stopwatch" color="#F4B894" />
                                    </div>
                                    <div class="col-6">
                                        <Icon size="30" type="ios-warning-outline" color="#F26A5A" />
                                    </div>
                                </div>
                            </div>
                            <div class="posted-item-info-views">
                                <Icon type="md-eye" />
                                <span v-if="notification.view_cnt !== null">{{notification.view_cnt.length}}</span>
                                <span v-else>0</span>
                            </div>
                            <div class="posted-item-info-time">
                                <Icon type="ios-clock-outline" />
                                <timeago :datetime="notification.created_at" :auto-update="60"></timeago>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <InfiniteLoading 
                        class="pb-3"
                        @infinite="infiniteHandlerNotification"
                        spinner="circles"
                    >
                    
                        <div slot="no-more">{{$t('infinitLoader').downgradednotificationNoMore}}</div>
                        <div slot="no-results" class="position-relative row m-0 p-2 h-50 d-flex justify-content-center align-items-center">
                            <div class="no-fac text-center p-5 m-5">
                                <Icon size="150" type="ios-search" />
                                <h5>{{ $t('infinitLoader').downgradednotificationNoResult }}</h5>
                            </div>
                        </div>
                    </InfiniteLoading>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
//infinitLoding
import InfiniteLoading from 'vue-infinite-loading';
import {getDowngradNotificationList, upgradeNotification} from '~/api/notification'
import Category from './category'
import { mapGetters } from 'vuex'
import i18n from '~/plugins/i18n'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').downgradeNotification }
    },
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

        upgradeNotification(notification){
            let notiId = {
                id: notification.id
            }
            upgradeNotification(notiId)
            .then(res=>{
                this.success(i18n.t('alert').upgrade);
                this.$router.push({path: '/notification/index'});
            })
            .catch(error=>{
                console.log(error.response);
            })
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
    }
}
</script>