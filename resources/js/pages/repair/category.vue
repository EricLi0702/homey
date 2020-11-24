<template>
    <div class="col-12 col-md-4 m-0 p-0 pr-md-4">
        <div class="position-sticky pb-1" style="top: 150px;">
            <Collapse class="box-block" v-model="collapse1">
                <Panel hide-arrow name="item1">
                    {{$t('categories').repair.Categories}}
                    <div slot="content" class="community-category-list p-3">
                        <div class=" ccl-item d-flex justify-content-between">
                            <p>1. {{$t('categories').repair.countOfThisMonth}}</p>
                            <Badge type="normal" :count="monthData"></Badge>
                        </div>
                        <div class=" ccl-item d-flex justify-content-between">
                            <p>2. {{$t('categories').repair.countOfThisWeek}}</p>
                            <Badge type="normal" :count="weekData"></Badge>
                        </div>
                        <div class=" ccl-item d-flex justify-content-between">
                            <p>3. {{$t('categories').repair.countOfToday}}</p>
                            <Badge type="normal" :count="todayData"></Badge>
                        </div>
                        <div class=" ccl-item d-flex justify-content-between">
                            <p>4. {{$t('categories').repair.countOfRegisteredUser}}</p>
                            <Badge type="normal" :count="registerCnt"></Badge>
                        </div>
                        <div class=" ccl-item d-flex justify-content-between">
                            <p>5. {{$t('categories').repair.countOfCurrentUser}}</p>
                            <Badge type="normal" :count="currentCnt"></Badge>
                        </div>
                    </div>
                </Panel>
            </Collapse>
            
            <Collapse class="box-block" v-model="collapse2">
                <Panel hide-arrow name="item2">
                    {{$t('categories').repair.repairOfThisMonth}}:{{this.monthData}}
                    <div slot="content" class="community-category-list p-3">
                        <div class=" ccl-item">
                            <p>{{$t('categories').repair.percentOfThisMonth}}</p>
                            <Progress class="w-100" :percent="todayPro" status="active" />
                        </div>
                        <div class=" ccl-item">
                            <p>{{$t('categories').repair.percentOfThisWeek}}</p>
                            <Progress class="w-100" :percent="weekPro" stroke-color="#D14429" status="active" />
                        </div>
                        <div class=" ccl-item">
                            <p>{{$t('categories').repair.currentUser_registeredUser}}</p>
                            <Progress class="w-100" :percent="userPro" stroke-color="#19be6b" status="active" />
                        </div>
                    </div>
                </Panel>
            </Collapse>
            <Collapse class="box-block" v-model="collapse3">
                <Panel hide-arrow name="item3">
                    {{$t('categories').repair.myActivityThread}}
                    <div slot="content" class="community-category-list p-3">
                        <div v-for="repair in repairData" :key="repair.id" >
                            <div class=" ccl-item d-flex justify-content-between">
                                <router-link :to="{path:`/repair/${repair.id}`}">
                                    <p>{{repair.title}}</p>
                                </router-link>
                                <Tag v-if="repair.status == 'pending'" color="warning">{{$t('common').pending}}</Tag>
                                <Tag v-else-if="repair.status == 'approved'" color="success">{{$t('common').approved}}</Tag>
                                <Tag v-else-if="repair.status == 'ongoing'" color="primary">{{$t('common').ongoing}}</Tag>
                                <Tag v-else-if="repair.status == 'finish'" color="default">{{$t('common').finish}}</Tag>
                            </div>
                        </div>
                    </div>
                </Panel>
            </Collapse>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import {getTop5Repair,getRepairCnt} from '~/api/repair'
import {getRepairJsonData} from '../../api/repair'

export default {
    data(){
        return{
            enJsonData:[],
            krJsonData:[],
            vnJsonData:[],
            repairJsonData:[],
            repairData:[],
            repairListRaw : [],
            monthData:1,
            todayData:0,
            weekData:0,
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
      currentUser:'auth/user',
      currentLang:'lang/locale'
    })
    },
    watch:{
        $route(to,from){
            this.$router.go()
        },
        currentLang:{
            handler(val){
                if(val == 'en'){
                    this.repairJsonData = this.enJsonData;
                }
                if(val == 'kr'){
                    this.repairJsonData = this.krJsonData;
                }
                if(val == 'vn'){
                    this.repairJsonData = this.vnJsonData;
                }
            },
            deep:true
        },
        repairJsonData:{
            handler(val){
                for(let i = 0; i < this.repairData.length; i++){
                    if(this.repairData[i].isSelectMode == 1){
                        let type = val[parseInt(this.repairListRaw[i].type)-1].label;
                        let object = val[parseInt(this.repairListRaw[i].type)-1].object[parseInt(this.repairListRaw[i].object)-1].label;
                        let title = val[parseInt(this.repairListRaw[i].type)-1].object[parseInt(this.repairListRaw[i].object)-1].title[parseInt(this.repairListRaw[i].title)-1].label;
                        this.repairData[i].type = type;
                        this.repairData[i].object = object;
                        this.repairData[i].title = title;
                    }
                }
            },
            deep:true
        }
    },

    created(){
        getRepairJsonData()
        .then(res=>{
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
        })
        .catch(err=>{
            console.log(err.response)
        })
    },

    mounted(){
        getTop5Repair(this.currentUser.id).then(res=>{
            this.repairData = res.data;
            for(let j = 0; j < res.data.length; j++){
                this.repairListRaw.push(JSON.parse(JSON.stringify(this.repairData[j])));
            }
            for(let i = 0; i < this.repairData.length; i++){
                
                if(this.repairData[i].isSelectMode == 1){
                    let type = this.repairJsonData[this.repairData[i].type-1].label;
                    let object = this.repairJsonData[this.repairData[i].type-1].object[this.repairData[i].object-1].label;
                    let title = this.repairJsonData[this.repairData[i].type-1].object[this.repairData[i].object-1].title[this.repairData[i].title-1].label;
                    this.repairData[i].type = type;
                    this.repairData[i].object = object;
                    this.repairData[i].title = title;
                }
            }
        }).catch(err=>{
            console.log(err)
        })
        getRepairCnt().then(res=>{
            this.todayData = res.data.today
            this.weekData = res.data.week
            this.monthData = res.data.month
            if(this.monthData == 0){
                this.todayPro = 0;
                this.weekPro = 0
            }
            else{
                this.todayPro = parseFloat((this.todayData/this.monthData*100).toFixed(2))
                this.weekPro = parseFloat((this.weekData/this.monthData*100).toFixed(2))
            }
            this.currentCnt = res.data.currentCnt
            this.registerCnt = res.data.registerCnt
            this.userPro = parseFloat((this.currentCnt/this.registerCnt*100).toFixed(2))
        })
    },
}
</script>