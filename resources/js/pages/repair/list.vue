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
                    <div class="posted-item position-relative" v-for="(repair,i) in repairList" :key="i" v-if="repairList.length">
                        <router-link :to="{path:`/repair/${repair.id}`}">
                            
                            <div class="pi-wrap float-left ">
                                <div class="user-info float-left">
                                    <div class="avatar">
                                        <img style="width:40px;" :src="`${baseUrl}/asset/img/icon/avatar.png`" class="rounded-circle profile-photo mr-1" alt="">
                                        <!-- <img src="https://i.pravatar.cc/40" alt=""> -->
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
                        <div slot="no-more">no more request</div>
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
// import VueTimeago from 'vue-timeago'
export default {
    components:{
        InfiniteLoading,
        Category,
        // VueTimeago
    },
    data(){
        return{
            baseUrl:window.base_url,
            repairList : [],

            //infinit loading
            pageOfRepair: 1,
            lastPageOfRepair: 0,
        }
    },

    async created(){
        // this.start();
    },

    methods:{
        async start(){
            await getrepairList()
            .then(res=>{
                console.log(res);
            })
        },

        async infiniteHandlerRepairRequest($state){
            let timeOut = 0;
            
            if (this.pageOfRepair > 1) {
                timeOut = 1000;
            }
            let vm = this;
            await getRepairList(this.pageOfRepair)
            .then(res=>{
                console.log("ohohoh",res);
                vm.lastpageOfRepair = res.data.last_page;

                $.each(res.data.data, function(key, value){
                        value.upload_file = JSON.parse(value.upload_file);
                        vm.repairList.push(value); 
                        console.log("wow",vm.repairList);
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