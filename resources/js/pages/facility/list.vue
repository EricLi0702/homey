<template>
    <div>
        <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 py-5 bg-white">
                <p>something...</p>
            </div>
        </div>
        <div class="container m-0 p-0 mx-auto pb-5">
            <div class="row m-0 p-0">
                <div class="col-12 col-md-4 m-0 p-0 pr-md-4">
                    <div class="box-block">
                        <div class="facility-category-title p-3">
                            Facilities
                        </div>
                        <div v-if="noFacility" class="facility-category-list p-3">
                        </div>
                        <div v-else class="facility-category-list p-3">
                            <div v-for="(facility, i) in facilityList" :key="i" class=" ccl-item d-flex justify-content-between">
                                <p @click="selectFacility(facility)">{{facility.name}}</p>
                                <Tag v-if="facility.isUsing == 0" color="success">possible to use</Tag>
                                <Tag v-else color="warning">impossible to use</Tag>
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
                            <h5>oops! there is no facility!</h5>
                        </div>
                    </div>
                    <div v-else class="posted-item position-relative row m-0 p-2">
                        <Button class="position-absolute" type="success" icon="md-calendar" style="top:20px; right:20px; z-index:1">Reservate</Button>
                        <Button class="position-absolute" type="success" icon="md-calendar" style="bottom:20px; left:20px; z-index:1">Reservate</Button>
                        <div class="p-1 pt-3 fac-name col-12 m-0 p-0 text-center">
                            <h1>{{selectedFacility.name}}</h1>
                            <p>Max:{{selectedFacility.max}}</p>
                        </div>
                        <div v-if="noFile" class="col-12 row m-0 p-0 pb-5">
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
                        <div v-else class="col-12 row m-0 p-0 pb-5">
                            <div class="col-12 col-lg-7 content-container">
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
                            <div class="col-12 col-lg-5 file-container p-0 pt-4">
                                <div v-if="selectedFacility.upload_file.imgUrl.length !== 0" class="post-img row m-0 p-0 mb-4 d-flex align-items-center">
                                    <div v-for="(image,i) in selectedFacility.upload_file.imgUrl" :key="i" class="post-img-item col-12 p-0 px-2" v-viewer>
                                        <img :src="image" alt="" class="w-100 mb-2" @click="showImage">
                                    </div>
                                </div>

                                <div v-if="selectedFacility.upload_file.videoUrl.length !== 0" class="post-video row m-0 p-0 mb-4">
                                    <div v-for="(video,i) in selectedFacility.upload_file.videoUrl" :key="i" class="post-video-item col-12 p-2 mb-2">
                                        <video-player  
                                            class="video-player-box vjs-custom-skin w-100"
                                            ref="videoPlayer"
                                            :options="getEachVideoSrc(video)"
                                            :playsinline="true"
                                            @ready="playerReadied(video)"
                                            >
                                        </video-player>
                                    </div>
                                </div>
                            
                                <div v-if="selectedFacility.upload_file.otherUrl.length !== 0" class="post-file row m-0 p-0 d-flex align-items-center mb-4">
                                    <div v-for="(file,i) in selectedFacility.upload_file.otherUrl" :key="i" class="post-file-item col-12 p-0 px-2 mb-2">
                                        <div class="d-flex align-items-center p-1 bg-light-gray position-relative">
                                            <Icon class="mr-2" size="35" type="ios-document-outline" />
                                            <div class="file-info">
                                                <p><strong>{{file.fileOriName}}</strong></p>
                                                <p><small>{{file.fileSize}}</small></p>
                                            </div>
                                            <a class="download-icon" :href="`http://asystem.test/upload/other/${file.fileName}`" :download="file.fileOriName">
                                                <Icon size="25" class="msg-file-download-ico msg-file-download-ico-send" type="md-download" />
                                            </a>
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
//image viewer
import 'viewerjs/dist/viewer.css'
import Viewer from 'v-viewer'
//video viewer
import 'video.js/dist/video-js.css'
import { videoPlayer } from 'vue-video-player'

export default {
    components:{
        Viewer,
        videoPlayer,
    },
    data(){
        return{
            facilityList : [],
            selectedFacility : {},
            noFile:false,
            noFacility:false,
            playerOptions: {
                // videojs options
                height:'200',
                muted: true,
                language: 'en',
                playbackRates: [0.7, 1.0, 1.5, 2.0],
                sources: [{
                    type: "video/mp4",
                    src: "https://cdn.theguardian.tv/webM/2015/07/20/150716YesMen_synd_768k_vp8.webm"
                }],
                // poster: "/static/images/author.jpg",
            },
        }
    },

    async created(){
        this.start();
    },

    computed:{
        player() {
            return this.$refs.videoPlayer.player
        }
    },

    methods:{
        playerReadied(video){
            this.playerOptions.sources.src = "http://asystem.test/uploads/video/"+video.fileName;
        },

        showImage(){
            const viewer = this.$el.getElementsByClassName('post-img-item').$viewer
            viewer.show()
        },

        getEachVideoSrc(video){
            this.playerOptions.sources.src = "http://asystem.test/uploads/video/"+video.fileName;
            return this.playerOptions
        },

        async start(){
            await getFacilityList()
            .then(res=>{
                console.log(res);
                if(res.data.length == 0){
                    this.noFacility = true;
                    return;
                }
                this.facilityList = res.data;
                for(let i = 0; i < this.facilityList.length ; i++){
                    this.facilityList[i].upload_file = JSON.parse(this.facilityList[i].upload_file);
                }
                this.selectedFacility = this.facilityList[0];
                if (this.selectedFacility.upload_file.imgUrl.length == 0 && 
                    this.selectedFacility.upload_file.otherUrl.length == 0 &&
                    this.selectedFacility.upload_file.videoUrl.length == 0){
                        this.noFile = true;
                }
            })
        },
        selectFacility(facility){
            this.noFile = false;
            this.selectedFacility = facility;
            if (this.selectedFacility.upload_file.imgUrl.length == 0 && 
                this.selectedFacility.upload_file.otherUrl.length == 0 &&
                this.selectedFacility.upload_file.videoUrl.length == 0){
                    this.noFile = true;
                }
        }
    }
}
</script>