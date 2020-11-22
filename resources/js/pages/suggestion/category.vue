<template>
    <div class="col-12 col-md-4 m-0 p-0 pr-md-4">
        <div class="position-sticky pb-1" style="top: 150px;">
            <Collapse class="box-block" v-model="collapse1">
                <Panel hide-arrow name="item1">
                    {{$t('categories').suggestion.Categories}}
                    <div slot="content" class="community-category-list p-3">
                        <div class=" ccl-item d-flex justify-content-between">
                            <p>1. {{$t('categories').suggestion.countOfThisMonth}}</p>
                            <Badge type="normal" :count="monthData"></Badge>
                        </div>
                        <div class=" ccl-item d-flex justify-content-between">
                            <p>2. {{$t('categories').suggestion.countOfThisWeek}}</p>
                            <Badge type="normal" :count="weekData"></Badge>
                        </div>
                        <div class=" ccl-item d-flex justify-content-between">
                            <p>3. {{$t('categories').suggestion.countOfToday}}</p>
                            <Badge type="normal" :count="todayData"></Badge>
                        </div>
                        <div class=" ccl-item d-flex justify-content-between">
                            <p>4. {{$t('categories').suggestion.countOfRegisteredUser}}</p>
                            <Badge type="normal" :count="registerCnt"></Badge>
                        </div>
                        <div class=" ccl-item d-flex justify-content-between">
                            <p>5. {{$t('categories').suggestion.countOfCurrentUser}}</p>
                            <Badge type="normal" :count="currentCnt"></Badge>
                        </div>
                    </div>
                </Panel>
            </Collapse>
            <Collapse class="box-block" v-model="collapse2">
                <Panel hide-arrow name="item2">
                    {{$t('categories').suggestion.suggestionOfThisMonth}}:{{this.monthData}}
                    <div slot="content" class="community-category-list p-3">
                        <div class=" ccl-item">
                            <p>{{$t('categories').suggestion.percentOfThisMonth}}</p>
                            <Progress class="w-100" :percent="todayPro" status="active"  />
                        </div>
                        <div class=" ccl-item">
                            <p>{{$t('categories').suggestion.percentOfThisWeek}}</p>
                            <Progress class="w-100" :percent="weekPro" stroke-color="#D14429" status="active"  />
                        </div>
                        <div class=" ccl-item">
                            <p>{{$t('categories').suggestion.currentUser_registeredUser}}</p>
                            <Progress class="w-100" :percent="userPro" stroke-color="#19be6b" status="active"  />
                        </div>
                    </div>
                </Panel>
            </Collapse>
            <Collapse class="box-block" v-model="collapse3">
                <Panel hide-arrow name="item3">
                    {{$t('categories').suggestion.myActivityThread}}
                    <div slot="content" class="community-category-list p-3">
                        <div v-for="suggestion in suggestionData" :key="suggestion.id" >
                            <div class=" ccl-item d-flex justify-content-between">
                                <router-link :to="{path:`/suggestion/${suggestion.id}`}">
                                    <p>{{suggestion.title}}</p>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </Panel>
            </Collapse>
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
            weekPro:0,
            userPro:0,
            registerCnt:0,
            currentCnt:0,
            collapse1:"item1",
            collapse2:"item2",
            collapse3:"item3"
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
        getTop5Suggestion(this.currentUser.id).then(res=>{
            this.suggestionData = res.data
        }).catch(err=>{
            console.log(err)
        })
        getSuggestionCnt().then(res=>{
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