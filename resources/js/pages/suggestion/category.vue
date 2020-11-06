<template>
    <div class="col-12 col-md-4 m-0 p-0 pr-md-4">
        <div class="box-block">
            <div class="community-category-title p-3">
                Categories
            </div>
            <div class="community-category-list p-3">
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Request repair</p>
                    <Badge type="normal" :count="17"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Fix Problem</p>
                    <Badge type="normal" :count="5"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Covid</p>
                    <Badge type="normal" :count="23"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Health</p>
                    <Badge type="normal" :count="56"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Children</p>
                    <Badge type="normal" :count="19"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Food</p>
                    <Badge type="normal" :count="38"></Badge>
                </div>
            </div>
        </div>
        <div class="box-block">
            <div class="community-category-title p-3">
                The count of suggestion on this month:{{this.monthData}}
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
                <div v-for="suggestion in suggestionData" :key="suggestion.id" >
                    <div class=" ccl-item d-flex justify-content-between">
                        <router-link :to="{path:`/notification/${suggestion.id}`}">
                            <p>{{suggestion.title}}</p>
                        </router-link>
                    </div>
                    <Divider />
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import {getTop5Suggestion,getSuggestionCnt} from '~/api/suggestion'
import {mapGetters} from 'vuex'
export default {
    data(){
        return{
            suggestionData:[],
            todayData:0,
            weekData:0,
            monthData:1,
            todayPro:0,
            weekPro:0
        }
    },
    computed:{
        ...mapGetters({
        currentUser:'auth/user'
        })
    },
    mounted(){
        getTop5Suggestion(this.currentUser.id).then(res=>{
            this.suggestionData = res.data
        }).catch(err=>{
            console.log(err)
        })
        getSuggestionCnt().then(res=>{
            console.log(res)
            this.todayData = res.data.today
            this.weekData = res.data.week
            this.monthData = res.data.month
            this.todayPro = parseFloat((this.todayData/this.monthData*100).toFixed(2))
            this.weekPro = parseFloat((this.weekData/this.monthData*100).toFixed(2))
        })
    }
}
</script>