<template>
    <div class="col-12 col-md-4 m-0 p-0 pr-md-4">
        <div class="box-block">
            <div class="community-category-title p-3">
                Categories
            </div>
            <div class="community-category-list p-3">
                <div class=" ccl-item d-flex justify-content-between">
                    <p>1. The count of community of this month</p>
                    <Badge type="normal" :count="monthData"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>2. The count of community of this week</p>
                    <Badge type="normal" :count="weekData"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>3. The count of community of today</p>
                    <Badge type="normal" :count="todayData"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>4. The count of registerd user</p>
                    <Badge type="normal" :count="registerCnt"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>5. The count of current user</p>
                    <Badge type="normal" :count="currentCnt"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>6. Notice of Rent Increase</p>
                    <Badge type="normal" :count="38"></Badge>
                </div>
            </div>
        </div>
        <!-- <div class="box-block">
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
        </div> -->
        <div class="box-block">
            <div class="community-category-title p-3">
                The count of communtiy on this month:{{this.monthData}}
            </div>
            <div class="community-category-list p-3">
                <div class=" ccl-item">
                    <p>Today notification percent of this month.</p>
                    <Progress class="w-100" :percent="todayPro" :stroke-width="20" status="active" text-inside />
                </div>
                <div class=" ccl-item">
                    <p>CurrentWeek notification percent of this month</p>
                    <Progress class="w-100" :percent="weekPro" :stroke-width="20" status="active" text-inside />
                </div>
                <div class=" ccl-item">
                    <p>CurrentUser :: RegisterUser</p>
                    <Progress class="w-100" :percent="userPro" :stroke-width="20" status="active" text-inside />
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
import {getTop5Community,getCommunityCnt} from '~/api/community'
import {mapGetters} from 'vuex'
export default {
    data(){
        return{
            communityData:[],
            monthData:1,
            todayData:0,
            weekData:0,
            todayPro:0,
            weekPro:0,
            userPro:0,
            registerCnt:0,
            currentCnt:0,
        }
    },
    computed:{
        ...mapGetters({
        currentUser:'auth/user'
        })
    },
    watch:{
        $route(to,from){
            this.$router.go()
        }
    },

    mounted(){
        getTop5Community(this.currentUser.id).then(res=>{
            this.communityData = res.data
        }).catch(err=>{
            console.log(err)
        })
        getCommunityCnt(this.currentUser.id).then(res=>{
            this.todayData = res.data.today
            this.weekData = res.data.week
            this.monthData = res.data.month
            this.currentCnt = res.data.currentCnt
            this.registerCnt = res.data.registerCnt
            this.userPro = parseFloat((this.currentCnt/this.registerCnt*100).toFixed(2))
            this.todayPro = parseFloat((this.todayData/this.monthData*100).toFixed(2))
            this.weekPro = parseFloat((this.weekData/this.monthData*100).toFixed(2))
        })
    }
}
</script>