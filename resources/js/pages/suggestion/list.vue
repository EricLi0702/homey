<template>
    <div>
        <div class="container m-0 p-0 mx-auto">
            <div class="row m-0 p-0">
                <Category/>
                <div class="col-12 col-md-8 m-0 p-0">
                    <div v-if="suggestionList.length" class="posted-item position-relative" v-for="(suggestion,i) in suggestionList" :key="i" >
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
                                    <timeago :datetime="suggestion.created_at" :auto-update="60"></timeago>
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
                        <div slot="no-more">{{ $t('infinitLoader').suggestionNoMore }}</div>
                        <div slot="no-results" class="position-relative row m-0 p-2 h-50 d-flex justify-content-center align-items-center">
                            <div class="no-fac text-center p-5 m-5">
                                <Icon size="150" type="ios-search" />
                                <h5>{{ $t('infinitLoader').suggestionNoResult }}</h5>
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
import {getSuggestionList,registerSuggestion,updateSuggestion,delSuggestion} from '~/api/suggestion'
import Category from './category'
// import VueTimeago from 'vue-timeago'
import { mapGetters } from 'vuex'
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
            await getSuggestionList()
            .then(res=>{
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
    }
}
</script>