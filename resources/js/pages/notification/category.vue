<template>
    <div class="col-12 col-md-4 m-0 p-0 pr-md-4">
        <div class="box-block">
            <div class="community-category-title p-3">
                Categories
            </div>
            <div class="community-category-list p-3">
                <div class=" ccl-item d-flex justify-content-between">
                    <p>1. Notice to Pay or Quit</p>
                    <Badge type="normal" :count="17"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>2. Notice to Cure or Quit</p>
                    <Badge type="normal" :count="5"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>3. Unconditional Quit Notice</p>
                    <Badge type="normal" :count="23"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>4. Notice of Transfer of Ownership/Management</p>
                    <Badge type="normal" :count="56"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>5. Notice of Non-Renewal</p>
                    <Badge type="normal" :count="19"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>6. Notice of Rent Increase</p>
                    <Badge type="normal" :count="38"></Badge>
                </div>
            </div>
        </div>
        <div class="box-block">
            <div class="community-category-title p-3">
                The count of notification on this month:{{this.monthData}}
            </div>
            <div class="community-category-list p-3">
                <div class=" ccl-item">
                    <p>Today notification percent of this month.</p>
                    <Progress class="w-100" :percent="todayPro" :stroke-width="20" status="active" text-inside />
                </div>
                <div class=" ccl-item">
                    <p>CurrentWeek notification percent of this month</p>
                    <Progress class="w-100" :percent="weekPro" :stroke-width="20" stroke-color="#D14429" status="active" text-inside />
                </div>
            </div>
        </div>
        <div class="box-block">
            <div class="community-category-title p-3">
                My Activity Thread
            </div>
            <div class="community-category-list p-3">
                <div v-for="notification in notificationData" :key="notification.id" >
                    <div class=" ccl-item d-flex justify-content-between">
                        <router-link :to="{path:`/notification/${notification.id}`}">
                            <p>{{notification.title}}</p>
                        </router-link>
                    </div>
                    <Divider />
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import {getTop5Notification,getNotificationCnt} from '~/api/notification'
export default {
    data(){
        return{
            notificationData:[],
            todayData:0,
            weekData:0,
            monthData:1,
            firstWeek:0,
            secondWeek:0,
            thirdWeek:0,
            forthWeek:0,
            todayPro:0,
            oneWeekAgo:0,
            twoWeekAgo:0,
            threeWeekAgo:0,
            fourWeekAgo:0,
            todayPro:0,
            weekPro:0,
        }
    },
    computed:{
    ...mapGetters({
      currentUser:'auth/user'
    })
    },
    async mounted(){
        console.log('++++notification+++',this.currentUser)
        await getTop5Notification(this.currentUser.id).then(res=>{
            console.log('----res',res)
            this.notificationData = res.data
        }).catch(err=>{
            console.log(err)
        })
        await getNotificationCnt().then(res=>{
            console.log(res)
            this.todayData = res.data.today;
            this.weekData = res.data.week;
            this.monthData = res.data.month;
            console.l
            this.todayPro = parseFloat((this.todayData/this.monthData*100).toFixed(2))
            this.weekPro = parseFloat((this.weekData/this.monthData*100).toFixed(2))
            // this.firstWeek = res.data.firstWeek;
            // this.secondWeek = res.data.secondWeek;
            // this.thirdWeek = res.data.thirdWeek;
            // this.forthWeek = res.data.forthWeek;
            // this.oneWeekAgo = parseInt(this.firstWeek / this.monthData * 100)
            // this.twoWeekAgo = parseInt((this.secondWeek - this.firstWeek) / this.monthData * 100)
            // this.threeWeekAgo = parseInt((this.thirdWeek -this.secondWeek) / this.monthData * 100)
            // this.fourWeekAgo = parseInt((this.forthWeek -this.thirdWeek) / this.monthData * 100)

        }).catch(err=>{
            console.log(err)
        })
    },
}
</script>