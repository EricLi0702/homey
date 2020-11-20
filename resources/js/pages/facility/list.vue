<template>
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
                        <h5>oops! there is no facility!{{$t('community').View}}</h5>
                    </div>
                </div>
                <div v-else class="posted-item position-relative row m-0 p-2">
                    <div class="p-1 pt-3 fac-name col-12 m-0 p-0 text-center">
                        <h1>{{selectedFacility.name}}</h1>
                        <div class="d-flex align-items-center justify-content-center">
                            <p> {{$t('facility').maxNumberOfUser}} {{selectedFacility.max}}</p>
                            <Icon class="ml-2" size="25" type="ios-people" />
                        </div>
                    </div>
                    <div v-if="noFile" class="col-12 row m-0 p-0">
                        <Tabs class="w-100">
                            <TabPane label="Outline" icon="ios-paper">
                                <p class="p-2 w-100" v-html="selectedFacility.outline" ></p>
                            </TabPane>
                            <TabPane label="Equipments" icon="ios-pie-outline">
                                <p class="w-100 p-2">{{selectedFacility.equipment}}</p>
                            </TabPane>
                            <TabPane label="N.B" icon="ios-warning-outline">
                                <p class="w-100 p-2">{{selectedFacility.nb}}</p>
                            </TabPane>
                        </Tabs>
                    </div>
                    <div v-else class="col-12 row m-0 p-0">
                        <div class="facility-cover-image w-100" v-if="selectedFacility.upload_file.imgUrl.length !== 0">
                            <img :src="selectedFacility.upload_file.imgUrl[0]" alt="" class="w-100 mb-2">
                        </div>
                        <div class="col-12 col-lg-12 content-container">
                            <div class="row m-0 ">
                                <Tabs class="w-100 mb-3">
                                    <TabPane label="Outline" icon="ios-paper">
                                        <p class="w-100 p-2" v-html="selectedFacility.outline"></p>
                                    </TabPane>
                                    <TabPane label="Equipments" icon="ios-pie-outline">
                                        <p class="w-100 p-2">{{selectedFacility.equipment}}</p>
                                    </TabPane>
                                    <TabPane label="N.B" icon="ios-warning-outline">
                                        <p class="w-100 p-2">{{selectedFacility.nb}}</p>
                                    </TabPane>
                                </Tabs>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 file-container p-0">
                            <div v-if="selectedFacility.upload_file.imgUrl.length !== 0" class="post-img row m-0 p-0 mb-4 d-flex align-items-center">
                                <div v-for="(image,i) in selectedFacility.upload_file.imgUrl" :key="i" class="post-img-item col-12 col-md-6 col-lg-4 col-xl-4 p-0 px-2" v-viewer>
                                    <img :src="image" alt="" class="w-100 mb-2" @click="showImage">
                                </div>
                            </div>

                            <div v-if="selectedFacility.upload_file.videoUrl.length !== 0" class="post-video row m-0 p-0 mb-4">
                                <div v-for="(video,i) in selectedFacility.upload_file.videoUrl" :key="i" class="post-video-item col-12 p-2 mb-2">
                                    <video-player  
                                        class="video-player-box vjs-custom-skin w-100"
                                        ref="videoPlayer"
                                        :options="playerOptionsGroup[i]"
                                        :playsinline="true"
                                        >
                                    </video-player>
                                </div>
                            </div>
                        
                            <div v-if="selectedFacility.upload_file.otherUrl.length !== 0" class="post-file row m-0 p-0 d-flex align-items-center mb-4">
                                <div v-for="(file,i) in selectedFacility.upload_file.otherUrl" :key="i" class="post-file-item col-12 col-md-6 col-lg-4 col-xl-4 p-0 px-2 mb-2">
                                    <div class="d-flex align-items-center p-1 bg-light-gray position-relative">
                                        <Icon class="mr-2" size="35" type="ios-document-outline" />
                                        <div class="file-info">
                                            <p><strong>{{file.fileOriName}}</strong></p>
                                            <p><small>{{file.fileSize}}</small></p>
                                        </div>
                                        <a class="download-icon" :href="`${baseUrl}/upload/other/${file.fileName}`" :download="file.fileOriName">
                                            <Icon size="25" class="msg-file-download-ico msg-file-download-ico-send" type="md-download" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="currentUser.roleId == 3 ||  currentUser.roleId == 4" class="px-2 col-12 pb-3">
                        <p v-if="selectedFacilityAlreadyReservated(selectedFacility)" class="float-right">{{$t('facility').YouAlready}}</p>
                        <p v-else>
                            <Button v-if="isRegisterToFacility" @click="toggleRegisterForm" class="float-right" type="warning" icon="md-calendar">{{$t('facility').Abort}}</Button>
                            <Button v-else @click="toggleRegisterForm" class="float-right" type="success" icon="md-calendar">{{$t('facility').Reservate}}</Button>
                        </p>
                    </div>
                </div>
                <div v-if="isRegisterToFacility" class="bg-white p-2 mt-3 animate__animated animate__fadeIn row m-0"> 
                    <Form :model="createReservationData" class="w-100">
                        <div class="col-12 mt-4 mb-3 gray-input">
                            <Input v-model="createReservationData.title" :placeholder="$t('facility').enterTitle" />
                        </div>
                        <div class="col-12 mb-3 gray-input fac-max d-flex align-items-center">
                            <Icon class="mr-2" size="25" type="ios-people" />
                            <InputNumber :max="selectedFacility.max" :min="1" v-model="createReservationData.max"></InputNumber>
                            <p class="text-secondary ml-4">({{$t('facility').MaximumEquipment}})</p>
                        </div>
                        <div class="col-12 mb-3">
                            <DatePicker class="w-100" :options="disableBeforeDate" @on-change="notiDateChange" type="datetimerange" :placeholder="$t('facility').checkYourDate"></DatePicker>
                        </div>
                        <div class="col-12 mb-3">
                            <wysiwyg v-model="createReservationData.purpose" :placeholder="$t('facility').enterDescription" />
                        </div>
                    </Form>
                    <div v-if="currentUser.roleId == 3 || currentUser.roleId == 4 " class="col-12 text-right mb-3">
                        <Button @click="reservateNew" class="float-right" type="success" icon="md-calendar" :disabled="isReservating" :loading="isReservating" >{{$t('facility').Reservate}}</Button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import wysiwyg from "vue-wysiwyg"
import {getFacilityList} from '~/api/facility'
import {createReservation, getReservationList, getReservationMyData, getReservatoinCnt} from '~/api/reservation'
//image viewer
import 'viewerjs/dist/viewer.css'
import Viewer from 'v-viewer'
//video viewer
import 'video.js/dist/video-js.css'
import { videoPlayer } from 'vue-video-player'
import { mapGetters } from 'vuex'
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').FacilityList }
    },
    components:{
        Viewer,
        videoPlayer,
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
            baseUrl:window.base_url,
            facilityList : [],
            reservationMyData: [],
            selectedFacility : {},
            noFile:false,
            isNoMyReservation: false,
            noFacility:false,
            playerOptionsGroup:[],
            playerOptions: {
                // videojs options
                height:'450',
                muted: true,
                language: 'en',
                playbackRates: [0.7, 1.0, 1.5, 2.0],
                sources: [{
                    type: "video/mp4",
                    src: "https://cdn.theguardian.tv/webM/2015/07/20/150716YesMen_synd_768k_vp8.webm"
                }],
                // poster: "/static/images/author.jpg",
            },
            isRegisterToFacility:false,
            //disable before time(TimePicker)
            disableBeforeDate: {
                disabledDate (date) {
                    return date && date.valueOf() < Date.now() - 86400000;
                }
            },
            //createReservationData
            createReservationData:{
                title:'',
                purpose:'',
                max:1,
                period:'',
            },
            isReservating:false,

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
        player() {
            return this.$refs.videoPlayer.player
        },
    },

    methods:{
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
        notiDateChange(date){
            this.createReservationData.period = date;
        },

        async reservateNew(){
            if(this.createReservationData.title.trim() == ''){
                return this.error('Title is required')
            }
            if(this.createReservationData.period.length == 0){
                return this.error('Period is required')
            }
            if(this.createReservationData.purpose.trim() == ''){
                return this.error('Purpose is required')
            }
            let payload = {
                reservationData: this.createReservationData,
                aptId : this.selectedFacility.aptId,
                facilityId : this.selectedFacility.id,
            };
            console.log("payload", payload);
            this.isReservating = true;
            await createReservation(payload)
            .then(res=>{
                this.selectedFacility.reservation_data.push(res.data.reservation);
                this.createReservationData.title = '';
                this.createReservationData.purpose = '';
                this.createReservationData.max = 1;
                this.createReservationData.period = '';
                this.isRegisterToFacility = false;
            })
            .catch(err=>{
                console.log(err)
            })
            this.isReservating = false;
        },

        toggleRegisterForm(){
            if(this.isRegisterToFacility == true){
                this.createReservationData.title = '';
                this.createReservationData.purpose = '';
                this.createReservationData.max = 1;
                this.createReservationData.period = '';
            }
            this.isRegisterToFacility = !this.isRegisterToFacility;
        },

        playerReadied(video){
            this.playerOptions.sources[0].src = "http://asystem.test/uploads/video/"+video.fileName;
        },

        showImage(){
            const viewer = this.$el.getElementsByClassName('post-img-item').$viewer
            viewer.show()
        },

        getEachVideoSrc(video){
            this.playerOptions.sources[0].src = "http://asystem.test/uploads/video/"+video.fileName;
            return this.playerOptions
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
                    for(let j = 0; j < this.facilityList[i].reservation_data.length ; j++){
                        if( this.facilityList[i].reservation_data[j].userId == this.currentUser.id){
                            this.reservationMyData.push(this.facilityList[i].reservation_data[j]);
                        }
                    }
                    if(this.reservationMyData.length == 0){
                        this.isNoMyReservation = true;
                    }
                }
                this.selectedFacility = this.facilityList[0];
                console.log("asdfasdf",this.facilityList);
                //video url
                let videoUrlGroup = this.selectedFacility.upload_file.videoUrl;
                for(let i = 0; i < videoUrlGroup.length ; i++){
                    let clonedOption = JSON.parse(JSON.stringify(this.playerOptions));
                    clonedOption.sources[0].src = this.baseUrl + '/uploads/video/'+videoUrlGroup[i].fileName;
                    this.playerOptionsGroup.push(clonedOption);
                }
                //check no file
                if (this.selectedFacility.upload_file.imgUrl.length == 0 && 
                    this.selectedFacility.upload_file.otherUrl.length == 0 &&
                    this.selectedFacility.upload_file.videoUrl.length == 0){
                        this.noFile = true;
                }
            })
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
        
        selectFacility(facility){
            //init data
            this.createReservationData.title = '';
            this.createReservationData.purpose = '';
            this.createReservationData.max = 1;
            this.createReservationData.period = '';
            this.isRegisterToFacility = false;
            this.noFile = false;
            this.playerOptionsGroup = [];
            //
            this.selectedFacility = facility;
            //video url
            let videoUrlGroup = this.selectedFacility.upload_file.videoUrl;
            for(let i = 0; i < videoUrlGroup.length ; i++){
                let clonedOption = JSON.parse(JSON.stringify(this.playerOptions));
                clonedOption.sources[0].src = this.baseUrl + '/uploads/video/'+videoUrlGroup[i].fileName;
                this.playerOptionsGroup.push(clonedOption);
            }
            //check no file
            if (this.selectedFacility.upload_file.imgUrl.length == 0 && 
                this.selectedFacility.upload_file.otherUrl.length == 0 &&
                this.selectedFacility.upload_file.videoUrl.length == 0){
                    this.noFile = true;
                }
        }
    }
}
</script>