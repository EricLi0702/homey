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
                    <div v-if="noRequest" class="position-relative row m-0 p-2 h-50 d-flex justify-content-center align-items-center">
                        <div class="no-fac text-center">
                            <Icon size="150" type="ios-search" />
                            <h5>{{ $t('repair').oopsThere }}</h5>
                        </div>
                    </div>

                    <div v-else-if="repairList.length" class="posted-item position-relative" v-for="(repair,i) in repairList" :key="i" >
                        <router-link :to="{path:`/repair/${repair.id}`}">
                            <div class="pi-wrap float-left ">
                                <div class="user-info float-left">
                                    <div class="avatar">
                                        <img :src="`${baseUrl}${repair.user_id.user_avatar}`" class="rounded-circle profile-photo mr-1" alt="">
                                    </div>
                                    <div class="icons text-center">
                                        <p>{{repair.id}}</p>
                                    </div>
                                </div>
                                <div class="post-text float-left">
                                    <h2>
                                        {{repair.title}}
                                    </h2>
                                    <p v-html="repair.desc"></p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="posted-item-info float-left">
                                <div class="posted-item-info-comments">
                                    <span>{{repair.type}}</span>
                                    <span>{{repair.object}}</span>
                                </div>
                                <div class="posted-item-info-views">
                                    <Tag v-if="repair.status == 'pending'" color="warning">{{repair.status}}</Tag>
                                    <Tag v-else-if="repair.status == 'approved'" color="success">{{repair.status}}</Tag>
                                    <Tag v-else-if="repair.status == 'ongoing'" color="primary">{{repair.status}}</Tag>
                                    <Tag v-else-if="repair.status == 'finish'" color="default">{{repair.status}}</Tag>
                                </div>
                                <div class="posted-item-info-time">
                                    <Icon type="ios-clock-outline" />
                                    <timeago :datetime="repair.created_at" :since="repair.created_at" :auto-update="60"></timeago>
                                </div>
                            </div>
                            <div class="clearfix">
                                
                            </div>
                        </router-link>
                    </div>
                    <InfiniteLoading 
                        class="pb-3"
                        @infinite="infiniteHandlerRepairRequest"
                        spinner="circles"
                    >
                        <div slot="no-more">{{ $t('welcome').noMoreRequest }}</div>
                    </InfiniteLoading>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
//infinitLoding
import InfiniteLoading from 'vue-infinite-loading';
import {getRepairList} from '~/api/repair'
import Category from './category'
import {getRepairJsonData} from '../../api/repair'
import { mapGetters } from 'vuex'
// import VueTimeago from 'vue-timeago'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').repairRequestList }
    },
    components:{
        InfiniteLoading,
        Category,
        // VueTimeago
    },
    data(){
        return{
            enJsonData:[],
            krJsonData:[],
            vnJsonData:[],
            repairJsonData:null,
            baseUrl:window.base_url,
            repairList : [],
            noRequest:false,
            //infinit loading
            pageOfRepair: 1,
            lastPageOfRepair: 0,
            
        }
    },

    computed:{
        ...mapGetters({
            currentLang:'lang/locale'
        })
    },

    created(){
        console.log(this.currentLang);
        getRepairJsonData()
        .then(res=>{
            console.log(res.data)
            this.enJsonData = JSON.parse(res.data[0].repair_type);
            this.krJsonData = JSON.parse(res.data[1].repair_type);
            this.vnJsonData = JSON.parse(res.data[2].repair_type);
            if(this.currentLang == 'en'){
                this.repairJsonData = this.enJsonData;
            }
            else if(this.currentLang == 'kr'){
                this.repairJsonData = this.krJsonData;
            }
            else if(this.currentLang == 'vn'){
                this.repairJsonData = this.vnJsonData;
            }
            console.log("123123",this.repairJsonData)
        })
        .catch(err=>{
            console.log(err.response)
        })
    },

    methods:{
        async start(){
            await getrepairList()
            .then(res=>{
                console.log(res);
            })
        },

        async infiniteHandlerRepairRequest($state){
            // if(this.repairJsonData == null){
            //     return;
            // }
            let timeOut = 0;
            
            if (this.pageOfRepair > 1) {
                timeOut = 1000;
            }
            let vm = this;
            await getRepairList(this.pageOfRepair)
            .then(res=>{
                if(vm.pageOfRepair == 1 && res.data.data.length == 0){
                    this.noRequest = true;
                    $state.complete();
                    return;
                }
                vm.lastpageOfRepair = res.data.last_page;

                $.each(res.data.data, function(key, value){
                        value.upload_file = JSON.parse(value.upload_file);
                        if(!isNaN(value.type)){
                            console.log("select mode", value);
                            let type = vm.repairJsonData[value.type-1].label;
                            let object = vm.repairJsonData[value.type-1].object[value.object-1].label;
                            let title = vm.repairJsonData[value.type-1].object[value.object-1].title[value.title-1].label;
                            value.type = type;
                            value.object = object;
                            value.title = title;
                        }
                        vm.repairList.push(value); 
                    });
                if (vm.pageOfRepair - 1 === vm.lastpageOfRepair) {
                    $state.complete();
                }
                else {
                    $state.loaded();
                }
                vm.pageOfRepair = vm.pageOfRepair + 1;
            });
        },
    }
}
</script>