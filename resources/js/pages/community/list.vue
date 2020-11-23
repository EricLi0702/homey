<template>
    <div>
        <div class="container m-0 p-0 mx-auto">
            <div class="row m-0 p-0">
                <Category/>
                <div class="col-12 col-md-8 m-0 p-0">
                    <div v-if="communityList.length" class="posted-item position-relative" v-for="(community,i) in communityList" :key="i" >
                        <router-link :to="{path:`/community/${community.id}`}">
                            <div class="pi-wrap float-left ">
                                <div class="user-info float-left">
                                    <div class="avatar">
                                        <img :src="`${baseUrl}${community.user_id.user_avatar}`" class="rounded-circle profile-photo mr-1" alt="">
                                    </div>
                                    <div class="icons text-center">
                                        <p>{{community.id}}</p>
                                    </div>
                                </div>
                                <div class="post-text float-left">
                                    <h2>
                                        {{community.title}}
                                    </h2>
                                    <p v-html="community.content"></p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="posted-item-info float-left">
                                <div class="posted-item-info-comments">
                                    <div class="pii-commentbg">
                                        <span v-if="community.comment_cnt !== null">{{community.comment_cnt.length}}</span>
                                        <span v-else>0</span>
                                        <div class="mark">
                                        </div>
                                    </div>
                                </div>
                                <div class="posted-item-info-views">
                                    <Icon type="md-eye" />
                                    <span v-if="community.view_cnt !== null">{{community.view_cnt.length}}</span>
                                    <span v-else>0</span>
                                </div>
                                <div class="posted-item-info-time">
                                    <Icon type="ios-clock-outline" />
                                    <timeago :datetime="community.created_at" :auto-update="60"></timeago>
                                </div>
                            </div>
                            <div class="clearfix">
                                
                            </div>
                        </router-link>
                    </div>
                    <InfiniteLoading 
                        class="pb-3"
                        @infinite="infiniteHandlerCommunity"
                        spinner="circles"
                    >
                        <div slot="no-more">{{ $t('infinitLoader').communityNoMore }}</div>
                        <div slot="no-results" class="position-relative row m-0 p-2 h-50 d-flex justify-content-center align-items-center">
                            <div class="no-fac text-center p-5 m-5">
                                <Icon size="150" type="ios-search" />
                                <h5>{{ $t('infinitLoader').communityNoResult }}</h5>
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
import {getCommunityList} from '~/api/community'
import Category from './category'
import { mapGetters } from 'vuex'
// import VueTimeago from 'vue-timeago'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').communityList }
    },
    components:{
        InfiniteLoading,
        Category,
        // VueTimeago
    },
    data(){
        return{
            baseUrl:window.base_url,
            communityList : [],

            noCommunity:false,

            //infinit loading
            pageOfCommunity: 1,
            lastPageOfCommunity: 0,
        }
    },

    computed:{ 
        ...mapGetters({
            currentUser: 'auth/user',
            currentLang:'lang/locale'
        }),
    },

    watch:{
        currentLang:{
            handler(val){
                this.$timeago.locale = this.currentLang;
            },
            deep:true
        }
    },

    async created(){
        // this.start();
        this.$timeago.locale = this.currentLang;
    },

    methods:{
        async start(){
            await getCommunityList()
            .then(res=>{
            })
        },

        async infiniteHandlerCommunity($state){
            let timeOut = 0;
            
            if (this.pageOfCommunity > 1) {
                timeOut = 1000;
            }
            let vm = this;
            await getCommunityList(this.pageOfCommunity)
            .then(res=>{
                if(vm.pageOfCommunity == 1 && res.data.data.length == 0){
                    this.noCommunity = true;
                    $state.complete();
                    return;
                }
                vm.lastpageOfCommunity = res.data.last_page;

                $.each(res.data.data, function(key, value){
                        
                        value.comment_cnt = JSON.parse(value.comment_cnt);
                        value.view_cnt = JSON.parse(value.view_cnt);
                        vm.communityList.push(value); 
                    });
                if (vm.pageOfCommunity - 1 === vm.lastpageOfCommunity) {
                    $state.complete();
                }
                else {
                    $state.loaded();
                }
                vm.pageOfCommunity = vm.pageOfCommunity + 1;
            });
        },
    }
}
</script>