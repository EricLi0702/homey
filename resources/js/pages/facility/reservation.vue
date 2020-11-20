<template>
    <div>
        <!-- <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 py-5 bg-white">
                <p>something...</p>
            </div>
        </div> -->
        <div class="container m-0 p-0 mx-auto pb-5">
            <div class="row m-0 p-0">
                <div class="col-12 col-md-4 m-0 p-0 pr-md-4">
                    <div class="position-sticky pb-1" style="top: 150px;">
                        <Collapse class="box-block" v-model="collapse1">
                            <Panel hide-arrow name="item1">
                                <div class="d-flex justify-content-between align-items-center">
                                    {{$t('facility').Facilities}} 
                                    <p v-if="currentUser.roleId == 2 || currentUser.roleId == 6 || currentUser.roleId == 7" class="pr-3">{{$t('facility').NumberOfReservation}}</p>
                                </div>
                                <div v-if="noFacility" slot="content" class="facility-category-list p-3">
                                </div>
                                <div v-else slot="content" class="facility-category-list p-3">
                                    <div v-for="(facility, i) in facilityList" :key="i" class=" ccl-item d-flex justify-content-between">
                                        <p @click="selectFacility(facility)">{{facility.name}}</p>
                                        <div v-if="currentUser.roleId == 3 || currentUser.roleId == 4">
                                            <Tag v-if="selectedFacilityAlreadyReservated(facility)" color="success">{{$t('facility').alreadyReservated}}</Tag>
                                            <Tag v-else-if="facility.isUsing == 0" color="success">{{$t('facility').possibleToUse}}</Tag>
                                            <Tag v-else color="warning">{{$t('facility').impossibleToUse}}</Tag>
                                        </div>
                                        <div v-else-if="currentUser.roleId == 2 || currentUser.roleId == 6 || currentUser.roleId == 7 " class="d-flex">
                                            <Tag color="success">{{facility.reservation_data.length}}</Tag>
                                        </div>
                                    </div>
                                </div>
                            </Panel>
                        </Collapse>

                        <Collapse class="box-block" v-model="collapse2">
                            <Panel hide-arrow name="item2">
                                {{$t('categories').facility.reservationOfThisMonth}}:{{this.monthData}}
                                <div slot="content" class="community-category-list p-3">
                                    <div class=" ccl-item">
                                        <p>{{$t('categories').facility.percentOfThisMonth}}</p>
                                        <Progress class="w-100" :percent="todayPro" :stroke-width="20" status="active" text-inside />
                                    </div>
                                    <div class=" ccl-item">
                                        <p>{{$t('categories').facility.percentOfThisWeek}}</p>
                                        <Progress class="w-100" :percent="weekPro" :stroke-width="20" stroke-color="#D14429" status="active" text-inside />
                                    </div>
                                    <div class=" ccl-item">
                                        <p>{{$t('categories').facility.currentUser_registeredUser}}</p>
                                        <Progress class="w-100" :percent="userPro" :stroke-width="20" status="active" text-inside />
                                    </div>
                                </div>
                            </Panel>
                        </Collapse>

                        <Collapse class="box-block" v-model="collapse3">
                            <Panel hide-arrow name="item3">
                                {{$t('categories').facility.myReservation}}
                                <div v-if="isNoMyReservation" slot="content" class="community-category-list p-3">
                                    <p>{{$t('categories').facility.noReservation}}</p>
                                </div>
                                <div v-else slot="content" class="community-category-list p-3">
                                    <div v-for="(reservation, i) in reservationMyData" :key="i">
                                        <div class=" ccl-item d-flex justify-content-between">
                                            <p>{{reservation.title}}</p>
                                            <p>{{}}</p>
                                        </div>
                                    </div>
                                </div>
                            </Panel>
                        </Collapse>
                    </div>
                </div>
                <div class="col-12 col-md-8 m-0 p-0">
                    <div v-if="noFacility" class="position-relative row m-0 p-2 h-50 d-flex justify-content-center align-items-center">
                        <div class="no-fac text-center">
                            <Icon size="150" type="ios-search" />
                            <h5>{{$t('facility').oopsNoFacility}}</h5>
                        </div>
                    </div>
                    <div v-else class="position-relative row m-0 p-0">
                        <div class="control-view-type col-12 mb-3 p-0">
                            <Button @click="toggleViewType" v-if="calendarView" type="warning" icon="ios-paper-outline">{{$t('facility').ListView}}</Button>
                            <Button @click="toggleViewType" v-else type="warning" icon="ios-calendar-outline">{{$t('facility').CalendarView}}</Button>
                        </div>
                        <div v-if="calendarView" class="col-12 m-0 row calendar-view-container posted-item">
                            
                        </div>
                        <div v-else class="control-view-type col-12 mb-3 p-0">
                            <div  v-for="(reservation, i) in selectedFacility.reservation_data" :key="i" v-if="selectedFacility.reservation_data.length" class="col-12 m-0 row list-view-container posted-item p-2 mb-3">
                                <div class="col-1">
                                    <div class="posted-item-user-info">
                                        <img :src="`${baseUrl}${reservation.user_id.user_avatar}`" class="rounded-circle profile-photo mr-1" alt="">
                                    </div>
                                </div>   
                                
                                <div class="col-11">
                                    <div class="posted-user-info d-flex justify-content-between">
                                        <p class="mb-2">{{reservation.user_id.name}}</p>
                                        <div class="reservation-period">
                                            <p>{{TimeView(reservation.periodFrom)}}</p>
                                            <p>{{TimeView(reservation.periodTo)}}</p>
                                        </div>
                                    </div>
                                    <div class="title">
                                        <h5>{{reservation.title}}</h5>
                                        <Tag color="success">{{reservation.status}}</Tag>
                                    </div>
                                    <div class="post-content p-2">
                                        <p v-html="reservation.purpose">s</p>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {getFacilityList} from '~/api/facility'
import {createReservation, getReservationList, getReservatoinCnt} from '~/api/reservation'
import { mapGetters } from 'vuex'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').reservation }
    },
    data(){
        return{
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
            collapse3:"item3",
            facilityList : [],
            reservationMyData: [],
            noFacility:false,
            isNoMyReservation: false,
            calendarView:false,
            baseUrl:window.base_url,
            selectedFacility : {}
        }
    },

    async created(){
        this.start();
        this.getReservatoinCnt();
    },

    computed:{
        ...mapGetters({
            currentUser: 'auth/user'
        }),
    },

    methods:{
        //toggle view type
        toggleViewType(){
            this.calendarView = !this.calendarView;
        },
        //check if user already reservated to a facility
        selectedFacilityAlreadyReservated(facility){
            if(facility.reservation_data.length > 0){
                for(let i = 0; i < facility.reservation_data.length ; i++){
                    if(this.currentUser.id == facility.reservation_data[i].userId){
                        return true;
                    }
                }
            }
            return false;
        },

        async start(){
            await getFacilityList()
            .then(res=>{
                if(res.data.length == 0){
                    this.noFacility = true;
                    return;
                }
                this.facilityList = res.data;
                this.selectedFacility = this.facilityList[0];
                for(let i = 0; i < this.facilityList.length ; i++){
                    this.facilityList[i].upload_file = JSON.parse(this.facilityList[i].upload_file);
                    for(let j = 0; j < this.facilityList[i].reservation_data.length ; j++){
                        if( this.facilityList[i].reservation_data[j].userId == this.currentUser.id){
                            this.reservationMyData.push(this.facilityList[i].reservation_data[j]);
                        }
                    }
                    if(this.reservationMyData.length == 0){
                        this.isNoMyReservation = true;
                    }
                }
            })
        },

        selectFacility(facility){
            this.selectedFacility = facility;
            console.log("this.selectedFacility", this.selectedFacility);
        },
        getReservatoinCnt(){
            getReservatoinCnt().then(res=>{
                console.log("res", res);
                this.todayData = res.data.today
                this.weekData = res.data.week
                this.monthData = res.data.month
                this.currentCnt = res.data.currentCnt
                this.registerCnt = res.data.registerCnt
                this.userPro = parseFloat((this.currentCnt/this.registerCnt*100).toFixed(2))
                this.todayPro = parseFloat((this.todayData/this.monthData*100).toFixed(2))
                this.weekPro = parseFloat((this.weekData/this.monthData*100).toFixed(2))
            })
        },
    }
}
</script>