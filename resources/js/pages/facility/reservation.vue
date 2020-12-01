<template>
    <div>
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
                                        <Progress class="w-100" :percent="todayPro" status="active"/>
                                    </div>
                                    <div class=" ccl-item">
                                        <p>{{$t('categories').facility.percentOfThisWeek}}</p>
                                        <Progress class="w-100" :percent="weekPro" stroke-color="#D14429" status="active"/>
                                    </div>
                                    <div class=" ccl-item">
                                        <p>{{$t('categories').facility.currentUser_registeredUser}}</p>
                                        <Progress class="w-100" :percent="userPro" stroke-color="#19be6b" status="active"/>
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
                                            <Tag v-if="reservation.status == 'pending'" color="magenta">{{$t('common').pending}}</Tag>
                                            <Tag v-else-if="reservation.status == 'allow'" color="green">{{$t('common').allow}}</Tag>
                                            <Tag v-else-if="reservation.status == 'deny'" color="error">{{$t('common').deny}}</Tag>
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
                        <div v-if="calendarView" class="col-12 m-0 row calendar-view-container posted-item p-4">
                            <reservation-calendar :locale="selectedLang" is-expanded :min-date='new Date()' :attributes='attributes'>
                                <template #day-popover="{ dayTitle  }" >
                                    <div class="text-xs text-gray-300 font-semibold text-center">
                                        <p>{{dayTitle }}</p>
                                        <p>{{$t('facility').SomeoneAlreadyReserved}}</p>
                                    </div>
                                </template>
                            </reservation-calendar>
                        </div>
                        <div v-else class="control-view-type col-12 mb-3 p-0">
                            <div  v-for="(reservation, i) in selectedFacility.reservation_data" :key="i" v-if="selectedFacility.reservation_data.length" class="col-12 m-0 row list-view-container posted-item p-4 mb-3">
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
                                        <Tag v-if="reservation.status == 'pending'" color="magenta">{{$t('common').pending}}</Tag>
                                        <Tag v-else-if="reservation.status == 'allow'" color="green">{{$t('common').allow}}</Tag>
                                        <Tag v-else-if="reservation.status == 'deny'" color="error">{{$t('common').deny}}</Tag>
                                    </div>
                                    <div class="post-content p-2">
                                        <p v-html="reservation.purpose"></p>
                                    </div>
                                </div> 
                                <div class="col-11 offset-1 d-flex justify-content-between align-items-center">
                                    <div class="allow-deny-control-btn-group" v-if="currentUser.roleId == 2 && isAutoReserve == false">
                                        <Button v-if="reservation.status == 'pending' || reservation.status == 'deny'" @click="allowReservation(reservation, i)" :disabled="isAllowing" :loading="isAllowing" type="primary" ghost>Allow</Button>
                                        <Button v-if="reservation.status == 'pending' || reservation.status == 'allow'" @click="denyReservation(reservation, i)" :disabled="isDenying" :loading="isDenying" type="error" ghost>Deny</Button>
                                    </div>
                                    <Icon v-if="reservation.userId == currentUser.id || currentUser.roleId == 2" size="25" type="ios-trash" color="#FD0000" @click="openRemoveModal(reservation, i)"/>
                                </div>
                                <Modal v-model="removeModal" width="360">
                                    <p slot="header" style="color:#f60;text-align:center">
                                        <Icon type="ios-information-circle"></Icon>
                                        <span v-if="deleteReservationData != null">{{$t('modal').delete}} : {{deleteReservationData.name}}</span>
                                    </p>
                                    <div class="text-center">
                                        <p>{{$t('modal').willDeleteReservation}}</p>
                                    </div>
                                    <div slot="footer">
                                        <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="delReservation()">{{ $t('apartment').delete }}</Button>
                                    </div>
                                </Modal>
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
import {
    createReservation, 
    getReservationList, 
    getReservationCnt, 
    delReservation,
    allowReservation,
    denyReservation,
    } from '~/api/reservation'
import { mapGetters } from 'vuex'
import i18n from '~/plugins/i18n'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').reservation }
    },
    data(){
        return{
            attributes:[{
                key: 'today',
                highlight: true,
                dates: new Date(),
                popover: {
                    visibility: 'hover',
                },
                dates: [
                    { start: new Date(2020, 12, 14), end: new Date(2020, 12, 18) },
                    { start: new Date(2020, 12, 20), end: new Date(2020, 12, 22) },
                ]
            }],
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
            selectedFacility : {},
            alreadyReservedDates:[],
            selectedLang: '',
            deleteReservationData:{},
            removeModal: false,
            isDeleting: false,
            deleteDataIndex: -1,
            allowReservationData: {},
            allowDataIndex: -1,
            isAllowing: false,
            denyReservationData: {},
            denyDataIndex: -1,
            isDenying: false,
            isAutoReserve: false,
        }
    },

    async created(){
        this.start();
        this.getReservationCnt();
        if(this.currentLang == 'vn'){
            this.selectedLang = 'vi';
        }
        if(this.currentLang == 'en'){
            this.selectedLang = 'en';
        }
        if(this.currentLang == 'kr'){
            this.selectedLang = 'ko';
        }
    },

    computed:{
        ...mapGetters({
            currentUser: 'auth/user',
            currentLang:'lang/locale'
        }),
    },
    
    watch:{
        currentLang:{
            handler(val){
                if(val == 'vn'){
                    this.selectedLang = 'vi';
                }
                if(val == 'en'){
                    this.selectedLang = 'en';
                }
                if(val == 'kr'){
                    this.selectedLang = 'ko';
                }
            },
            deep:true
        }
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
                if(res.data.facilityData.length == 0){
                    this.noFacility = true;
                    return;
                }

                let isAuto = parseInt(res.data.isAutoReservation);
                if(isAuto == 0){
                    this.isAutoReserve = false;
                }else{
                    this.isAutoReserve = true;
                }

                this.facilityList = res.data.facilityData;
                this.selectedFacility = this.facilityList[0];
                for(let k = 0; k < this.selectedFacility.reservation_data.length; k++){
                    let reserveFrom = (this.selectedFacility.reservation_data[k].periodFrom.split(" "))[0];
                    let reserveTo = (this.selectedFacility.reservation_data[k].periodTo.split(" "))[0];
                    let reserveFromYear = parseInt((reserveFrom.split("-"))[0]);
                    let reserveFromMonth = parseInt((reserveFrom.split("-"))[1]) - 1;
                    let reserveFromDay = parseInt((reserveFrom.split("-"))[2]);
                    let reserveToYear = parseInt((reserveTo.split("-"))[0]);
                    let reserveToMonth = parseInt((reserveTo.split("-"))[1]) - 1;
                    let reserveToDay = parseInt((reserveTo.split("-"))[2]);
                    let startToEndObj = { 
                        start: new Date(reserveFromYear, reserveFromMonth, reserveFromDay), 
                        end: new Date(reserveToYear, reserveToMonth, reserveToDay) 
                    }
                    this.alreadyReservedDates.push(startToEndObj);
                    this.attributes[0].dates = this.alreadyReservedDates;
                }
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

        openRemoveModal(reservation, index){
            this.deleteReservationData = reservation;
            this.deleteDataIndex = index;
            this.removeModal = true;
        },

        allowReservation(reservation, index){
            this.allowReservationData = reservation;
            this.allowDataIndex = index;
            let obj={
                id: this.allowReservationData.id
            }
            allowReservation(obj)
            .then(res=>{
                this.selectedFacility.reservation_data[this.allowDataIndex].status = 'allow';
                this.success(i18n.t('alert').allowedReservation);
                this.allowReservationData = {};
                this.allowDataIndex = -1;
            })
            .catch(err=>{
                console.log(err.response);
                if(err.response.data.access == false){
                    this.error(i18n.t('alert').notAccessAllow);
                }
            })
        },

        denyReservation(reservation, index){
            this.denyReservationData = reservation;
            this.denyDataIndex = index;
            let obj={
                id: this.denyReservationData.id
            }
            denyReservation(obj)
            .then(res=>{
                this.selectedFacility.reservation_data[this.denyDataIndex].status = 'deny';
                this.success(i18n.t('alert').denyReservation);
                this.denyReservationData = {};
                this.denyDataIndex = -1;
            })
            .catch(err=>{
                console.log(err.response);
                if(err.response.data.access == false){
                    this.error(i18n.t('alert').notDenyAllow);
                }
            })
        },

        delReservation(){
            let obj = {
                id: this.deleteReservationData.id,
                userId: this.deleteReservationData.userId
            }
            this.isDeleting = true;
            delReservation(obj)
            .then(res=>{
                this.selectedFacility.reservation_data.splice(this.deleteDataIndex, 1)
                this.success(i18n.t('alert').removeSuccessfully);
                this.deleteReservationData = {};
                this.deleteDataIndex = -1;
                this.isDeleting = false;
                this.removeModal = false;
            })
            .catch(err=>{
                console.log(err.response);
                if(err.response.data.access == false){
                    this.error(i18n.t('alert').notDeleteAllow);
                }
                this.deleteReservationData = {};
                this.deleteDataIndex = -1;
                this.isDeleting = false;
                this.removeModal = false;
            });
        },

        selectFacility(facility){
            this.alreadyReservedDates = [];
            this.selectedFacility = facility;
            for(let k = 0; k < this.selectedFacility.reservation_data.length; k++){
                let reserveFrom = (this.selectedFacility.reservation_data[k].periodFrom.split(" "))[0];
                let reserveTo = (this.selectedFacility.reservation_data[k].periodTo.split(" "))[0];
                let reserveFromYear = parseInt((reserveFrom.split("-"))[0]);
                let reserveFromMonth = parseInt((reserveFrom.split("-"))[1]) - 1;
                let reserveFromDay = parseInt((reserveFrom.split("-"))[2]);
                let reserveToYear = parseInt((reserveTo.split("-"))[0]);
                let reserveToMonth = parseInt((reserveTo.split("-"))[1]) - 1;
                let reserveToDay = parseInt((reserveTo.split("-"))[2]);
                let startToEndObj = { 
                    start: new Date(reserveFromYear, reserveFromMonth, reserveFromDay), 
                    end: new Date(reserveToYear, reserveToMonth, reserveToDay) 
                }
                this.alreadyReservedDates.push(startToEndObj);
                this.attributes[0].dates = this.alreadyReservedDates;
            }
        },
        getReservationCnt(){
            getReservationCnt().then(res=>{
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