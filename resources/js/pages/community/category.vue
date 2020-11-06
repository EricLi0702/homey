<template>
    <div class="col-12 col-md-4 m-0 p-0 pr-md-4">
        <div class="box-block">
            <div class="community-category-title p-3">
                Categories
            </div>
            <div class="community-category-list p-3">
                <div class=" ccl-item d-flex justify-content-between">
                    <p>(1)	What comes to mind when you hear the word ‘rent’?</p>
                    <Badge type="primary" :count="64"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>(2)	Do you think landlords charge too much for rent?</p>
                    <Badge type="primary" :count="37"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>(3)	Is it better to rent or buy property?</p>
                    <Badge type="primary" :count="15"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>(4)	Should kids with jobs pay rent to their parents?</p>
                    <Badge type="primary" :count="48"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>(5)	What do you need to think about before renting a place to live?</p>
                    <Badge type="primary" :count="12"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>(6)	How important are rent agreements?</p>
                    <Badge type="primary" :count="52"></Badge>
                </div>
            </div>
        </div>
        <div class="box-block">
            <div class="community-category-title p-3">
                Services
            </div>
            <div class="community-category-list p-3">
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Asset Management</p>
                    <Badge type="primary" :count="43"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Facilities Management</p>
                    <Badge type="primary" :count="65"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>International Residential</p>
                    <Badge type="primary" :count="12"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Research & Consultancy</p>
                    <Badge type="primary" :count="42"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Residential</p>
                    <Badge type="primary" :count="51"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Serviced Apartment</p>
                    <Badge type="primary" :count="24"></Badge>
                </div>
            </div>
        </div>
        <div class="box-block">
            <div class="community-category-title p-3">
                My Activity Thread
            </div>
            <div class="community-category-list p-3">
                <div v-for="community in communityData" :key="community.id" >
                    <div class=" ccl-item d-flex justify-content-between">
                        <router-link :to="{path:`/notification/${community.id}`}">
                            <p>{{community.title}}</p>
                        </router-link>
                    </div>
                    <Divider />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {getTop5Community} from '~/api/community'
import {mapGetters} from 'vuex'
export default {
    data(){
        return{
            communityData:[]
        }
    },
    computed:{
        ...mapGetters({
        currentUser:'auth/user'
        })
    },
    async mounted(){
        getTop5Community(this.currentUser.id).then(res=>{
            this.communityData = res.data
        }).catch(err=>{
            console.log(err)
        })
    }
}
</script>