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
                    <div class="box-block">
                        <div class="facility-category-title p-3">
                            {{$t('facility').Facilities}}
                        </div>
                        <div v-if="noFacility" class="facility-category-list p-3">
                        </div>
                        <div v-else class="facility-category-list p-3">
                            <div v-for="(facility, m) in facilityList" :key="m" class=" ccl-item d-flex justify-content-between">
                                <p>{{facility.name}}</p>
                                <Tag v-if="selectedFacilityAlreadyReservated(facility)" color="success">{{$t('facility').alreadyReservated}}</Tag>
                                <Tag v-else-if="facility.isUsing == 0" color="success">{{$t('facility').possibleToUse}}</Tag>
                                <Tag v-else color="warning">{{$t('facility').impossibleToUse}}</Tag>
                            </div>
                        </div>
                    </div>
                    <div class="box-block">
                        <div class="facility-category-title p-3">
                            Importantance on this week
                        </div>
                        <div class="facility-category-list p-3">
                            <div class=" ccl-item">
                                <p>Repair Lamps</p>
                                <Progress class="w-100" :percent="45" :stroke-width="20" status="active" text-inside />
                            </div>
                            <div class=" ccl-item">
                                <p>Look up broken equipment</p>
                                <Progress class="w-100" :percent="78" :stroke-width="20" stroke-color="#D14429" status="active" text-inside />
                            </div>
                            <div class=" ccl-item">
                                <p>Lorem ipsum dolor sit amet.</p>
                                <Progress class="w-100" :percent="96" :stroke-width="20" stroke-color="#04619F" status="active" text-inside />
                            </div>
                            <div class=" ccl-item ">
                                <p>Lorem ipsum dolor sit amet.</p>
                                <Progress class="w-100" :percent="63" :stroke-width="20" stroke-color="#000000" status="active" text-inside />
                            </div>
                            <div class=" ccl-item">
                                <p>Lorem ipsum dolor sit amet.</p>
                                <Progress class="w-100" :percent="89" :stroke-width="20" stroke-color="#737375" status="active" text-inside />
                            </div>
                            <div class=" ccl-item">
                                <p>Lorem ipsum dolor sit amet.</p>
                                <Progress class="w-100" :percent="23" :stroke-width="20" stroke-color="#F6684E" status="active" text-inside />
                            </div>
                        </div>
                    </div>
                    <div class="box-block">
                        <div class="community-category-title p-3">
                            My Activity Thread
                        </div>
                        <div class="community-category-list p-3">
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>This Dock Turns Your iPhone Into a Bedside Lamp</p>
                            </div>
                            <Divider />
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>Who Wins in the Battle for Power on the Internet?</p>
                            </div>
                            <Divider />
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>Sony QX10: A Funky, Overpriced Lens Camera for Your Smartphone</p>
                            </div>
                            <Divider />
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>FedEx Simplifies Shipping for Small Businesses</p>
                            </div>
                            <Divider />
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>Loud and Brave: Saudi Women Set to Protest Driving Ban</p>
                            </div>
                            <Divider />
                            <div class=" ccl-item d-flex justify-content-between">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
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
                            <Button @click="toggleViewType" v-if="calendarView" type="warning" icon="ios-calendar-outline">{{$t('facility').ListView}}</Button>
                            <Button @click="toggleViewType" v-else type="warning" icon="md-paper">{{$t('facility').CalendarView}}</Button>
                        </div>
                        <div v-if="calendarView" v-for="(facility, j) in facilityList" :key="j" class="col-12 m-0 row calendar-view-container posted-item">
                            
                        </div>
                        <div v-else>
                            <div  v-for="(facility, i) in facilityList" :key="i" v-if="facility.reservation_data.length" class="col-12 m-0 row list-view-container posted-item p-2 mb-3">
                                <div v-for="(reservation, k) in facility.reservation_data"  :key="k" v-if="facility.reservation_data.length" class="row col-12 m-0">
                                    <div class="col-1">
                                        <div class="posted-item-user-info">
                                            <img style="width:40px;" :src="`${baseUrl}/asset/img/icon/avatar.png`" class="rounded-circle profile-photo mr-1" alt="">
                                        </div>
                                    </div>   
                                    
                                    <div class="col-11">
                                        <div class="posted-user-info d-flex justify-content-between">
                                            <p class="mb-2">{{facility.user_id.name}}</p>
                                            <div class="reservation-period">
                                                <p>{{TimeView(reservation.periodFrom)}}</p>
                                                <p>{{TimeView(reservation.periodTo)}}</p>
                                            </div>
                                        </div>
                                        <div class="title">
                                            <h3>{{reservation.title}}</h3>
                                            <Tag color="success">{{reservation.status}}</Tag>
                                        </div>
                                        <div class="post-content p-2">
                                            <p>something</p>
                                        </div>
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
import {createReservation, getReservationList} from '~/api/reservation'
import { mapGetters } from 'vuex'
export default {
    data(){
        return{
            facilityList : [],
            noFacility:false,
            calendarView:false,
            baseUrl:window.base_url,
        }
    },

    async created(){
        this.start();
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
                for(let i = 0; i < this.facilityList.length ; i++){
                    this.facilityList[i].upload_file = JSON.parse(this.facilityList[i].upload_file);
                }
            })
        },
    }
}
</script>