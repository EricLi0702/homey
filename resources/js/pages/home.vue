<template>
  <div>
    <div class="fixed-background container-fluid">
        <div class="fixed-wrap">
            <div class="fixed">  
            </div>
            <div class="h-100 d-flex text-center align-items-center justify-content-center ">
                <div class="title row m-0 p-0">
                    <div class="subtitle col-md-12 mb-5" data-aos="zoom-out">
                        <h1>{{ $t('welcome').Vapartment }}</h1>
                    </div>
                    <div class="description mt-5 container" data-aos="fade-up">
                        <h4>{{ $t('welcome').WelcomeVapartment }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-content container-fluid">
        <div class="hero-items row">
            <div class="container">
                <div class="row align-middle">
                  <router-link :to="{ name: 'notification' }" class="col-12 col-sm-12 col-md-6 col-lg-4 column">
                    <div class="card-hero gr-1">
                      <div class="txt">
                        <h1>{{$t('welcome').Notification}}</h1>
                      </div>
                      <a href="#">{{$t('welcome').detail}}</a>
                      <div class="ico-card-hero">
                        <Icon type="ios-clipboard-outline" />
                      </div>
                    </div>
                  </router-link>
                  <router-link :to="{ name: 'community' }" class="col-12 col-sm-12 col-md-6 col-lg-4 column">
                      <div class="card-hero gr-1">
                          <div class="txt">
                              <h1>{{$t('community').cummunity}}</h1>
                          </div>
                          <a href="#">{{$t('welcome').detail}}</a>
                          <div class="ico-card-hero">
                            <Icon type="ios-people" />
                          </div>
                      </div>
                  </router-link>
                  <router-link :to="{ name: 'facility' }" class="col-12 col-sm-12 col-md-6 col-lg-4 column">
                      <div class="card-hero gr-1">
                          <div class="txt">
                              <h1>{{$t('welcome').PublicFacility}}</h1>
                          </div>
                          <a href="#">{{$t('welcome').detail}}</a>
                          <div class="ico-card-hero">
                          <Icon type="md-share" />
                          </div>
                      </div>
                  </router-link>
                  <router-link :to="{ name: 'suggestion' }" class="col-12 col-sm-12 col-md-6 col-lg-4 column">
                      <div class="card-hero gr-1">
                        <div class="txt">
                          <h1>{{$t('welcome').suggestion}}</h1>
                        </div>
                        <a href="#">{{$t('welcome').detail}}</a>
                        <div class="ico-card-hero">
                          <Icon type="md-chatbubbles" />
                        </div>
                      </div>
                  </router-link>
                  <router-link :to="{ name: 'repair' }" class="col-12 col-sm-12 col-md-6 col-lg-4 column">
                      <div class="card-hero gr-1">
                          <div class="txt">
                              <h1>{{$t('repair').repairRequest}}</h1>
                          </div>
                          <a href="#">{{$t('welcome').detail}}</a>
                          <div class="ico-card-hero">
                          <Icon type="ios-construct" />
                          </div>
                      </div>
                  </router-link>
                  <router-link :to="{ name: 'home' }" class="col-12 col-sm-12 col-md-6 col-lg-4 column">
                      <div class="card-hero gr-1">
                          <div class="txt">
                              <h1>{{$t('welcome').advertisement}}</h1>
                          </div>
                          <a href="#">{{$t('welcome').detail}}</a>
                          <div class="ico-card-hero">
                              <Icon type="md-home" />
                          </div>
                      </div>
                  </router-link>
                </div>
            </div>
        </div>
    </div>
    <div class="content container d-flex align-items-center justify-content-center my-4 pt-4" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
        <div class="row m-0 p-0">
            <div class="col-12 text-center mb-3">
                <h2 class="section-title">{{ $t('welcome').VApartmentManagementSystem }}</h2>
            </div>
            <div class="col-12 mb-2">
                <div class="main-content col-md-12 d-flex  align-items-center justify-content-center mb-5">
                    <read-more :more-str="$t('welcome').readmore" :text="$t('welcome').LadiesAndGentleMen" link="#" :less-str="$t('welcome').readless" :max-chars="150"></read-more>
                </div>
            </div>
        </div>
    </div>
    <!--start app video section-->
    <div id="video-app" class="video-app-1">
        <div class="overlay-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="video-play-button">
                            <a @click="openVideoPlayModal" class="video video-play mfp-iframe d-flex align-items-center justify-content-center">
                                <Icon type="md-play" size="27" class="ml-1"/>
                            </a>
                            <Modal
                                footer-hide	
                                :mask-closable="false"
                                v-model="videoPlayModal"
                                class-name="vertical-center-modal video-play-modal"
                                >
                                <video-player  
                                    class="video-player-box vjs-custom-skin w-100"
                                    ref="videoPlayer"
                                    :options="playerOptions"
                                    :playsinline="true"
                                    >
                                </video-player>
                            </Modal>
                        </div>
                    </div>
                </div>
            </div>
            <img :src="`${baseUrl}/asset/img/bg/bg-wave-sym.png`" alt="shape image" class="img-responsive">
        </div><!-- end overlay -->
    </div>
    <!--end app video section-->
    <div class="second-background container-fluid" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
        <div class="second-wrap">
            <!-- <div class="second">  
            </div> -->
            <div class="h-100 d-flex text-center align-items-center justify-content-center ">
                <div class="attraction">
                    <div class="row p-0 m-0">
                        <div class="a-title col-md-12 content">
                            <h2 class="section-title">{{$t('welcome').VapartmentServices}}</h2>
                        </div>
                        <p class="col-md-6 offset-md-3 col-8 offset-2 pt-2">{{$t('welcome').APTservice}}</p>
                        <hr>
                        <div class="container d-flex justify-content-between mt-5">
                            <p class="">{{$t('welcome').UPDATE}}</p>
                            <p class="">{{$t('welcome').DECORATION}}</p>
                            <p>{{$t('welcome').REPAIR}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="third-background container-fluid">
        <div class="third-wrap">
            <div class="third">  
            </div>
            <div class="h-100 container">
                <div class="row p-0 m-0">
                    <div class="col-md-6 d-flex row p-0 m-0 text-md-left text-center align-items-center text-white font-weight-bold" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                        <div class="w-100 m-3 p-2">
                            <div class="row w-100 m-0">
                                <div class="col-3">
                                    <p>{{$t('welcome').APTdetail_option_1}}</p>
                                </div>
                                <div class="col-9">
                                    582
                                    <!-- <p>{{$t('welcome').APTdetail_detail_1}}</p> -->
                                </div>
                            </div>
                            <div class="row w-100 m-0">
                                <div class="col-3">
                                    <p>{{$t('welcome').APTdetail_option_2}}</p>
                                </div>
                                <div class="col-9">
                                    <p>{{$t('welcome').APTdetail_detail_2}}</p>
                                </div>
                            </div>
                            <div class="row w-100 m-0">
                                <div class="col-3">
                                    <p>{{$t('welcome').APTdetail_option_3}}</p>
                                </div>
                                <div class="col-9">
                                    <p>{{$t('welcome').APTdetail_detail_3}}</p>
                                </div>
                            </div>
                            <div class="row w-100 m-0">
                                <div class="col-3">
                                    <p>{{$t('welcome').APTdetail_option_4}}</p>
                                </div>
                                <div class="col-9">
                                    <p>{{$t('welcome').APTdetail_detail_4}}</p>
                                </div>
                            </div>
                            <div class="row w-100 m-0">
                                <div class="col-3">
                                    <p>{{$t('welcome').APTdetail_option_5}}</p>
                                </div>
                                <div class="col-9">
                                    <p>{{$t('welcome').APTdetail_detail_5}}</p>
                                </div>
                            </div>
                            <div class="row w-100 m-0">
                                <div class="col-3">
                                    <p>{{$t('welcome').APTdetail_option_6}}</p>
                                </div>
                                <div class="col-9">
                                    <p>{{$t('welcome').APTdetail_detail_6}}</p>
                                </div>
                            </div>
                            <div class="row w-100 m-0">
                                <div class="col-3">
                                    <p>{{$t('welcome').APTdetail_option_7}}</p>
                                </div>
                                <div class="col-9">
                                    <p>{{$t('welcome').APTdetail_detail_7}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="structure col-md-6 row p-0 mt-2 " data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                        <div class="home-structure col-md-12">
                            <img :src="`${baseUrl}/asset/img/bg/room-structure.png`" alt="" class="p-4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="gallery container-fluid">
        <div class="row p-0 m-0">
            <div class="gallery-title col-md-12 d-flex text-center mt-5" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                <h2 class="col-md-12 m-0 p-0 section-title">{{$t('welcome').GALLERY}}</h2> 
            </div>
        </div>
        <section id="gallery">
            <div class="container-fluid">
              <div id="image-gallery">
                <div class="row">
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image" data-aos="flip-up" data-aos-easing="linear" data-aos-duration="1000">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room12.png"><img :src="`${baseUrl}/asset/img/bg/room1.jpg`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Bedroom</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image" data-aos="flip-up" data-aos-easing="linear" data-aos-duration="1000">
                    <div class="img-wrapper" style="height:95%">
                      <a href="/asset/img/bg/room12.png"><img :src="`${baseUrl}/asset/img/bg/room4.png`" class="img-responsive" style="height:100%"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Bedroom</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image" data-aos="flip-up" data-aos-easing="linear" data-aos-duration="1000">
                    <div class="img-wrapper" style="height:95%">
                      <a href="/asset/img/bg/room12.png"><img :src="`${baseUrl}/asset/img/bg/room3.jpg`" class="img-responsive" style="height:100%"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Bedroom</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image" data-aos="flip-up" data-aos-easing="linear" data-aos-duration="1000">
                    <div class="img-wrapper" style="height:95%">
                      <a href="/asset/img/bg/room12.png"><img :src="`${baseUrl}/asset/img/bg/room2.jpg`" class="img-responsive" style="height:100%"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Bedroom</p>
                      </div>
                    </div>
                  </div>
                  
                </div><!-- End row -->
              </div><!-- End image gallery -->
            </div><!-- End container --> 
          </section>    
    </div>
    <div class="container-fluid mt-5" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
        <div class="row p-0 m-0">
            <div class="add-title col-md-12 row p-0 m-0 content">
                <h2 class="col-md-12 d-flex align-items-center justify-content-center row p-0 m-0 section-title">{{ $t('welcome').theLinkLocation }}</h2>
            </div>
            <div class="add-content col-md-12 row p-0 mt-5">
                <p class="col-md-4 offset-md-4 text-center mb-5">Lô đất IC 32, Khu Đô Thị Nam Thăng Long, Tây Hồ, Hà Nội</p>
            </div>
        </div>
    </div>
    <GmapMap
      :center="{lat:10.8231, lng:106.6297}"
      :zoom="7"
      map-type-id="terrain"
      style="width: 100%; height: 300px"
    >
    </GmapMap>
  
  </div>
</template>

<script>
import AOS from 'aos'
import 'aos/dist/aos.css'
require('videojs-youtube');
import { videoPlayer } from 'vue-video-player'
import { mapGetters } from 'vuex'
import GoogleMapLoader from '~/components/GoogleMapLoader'
import 'video.js/dist/video-js.css'
export default {

  layout: 'default',

   metaInfo () {
    return { title: this.$t('metaInfo').home }
  },
  components:{
    videoPlayer,
  },

  data: () => ({
    title: window.config.appName,
    baseUrl:window.base_url,
    videoPlayModal:false,
    playerOptions: {
    // videojs options
        // autoplay: true,
        preload: "auto",
        fluid: true,
        height:'350',
        language: 'en',
        techOrder: [ 'youtube'],
        playbackRates: [0.7, 1.0, 1.5, 2.0],
        sources: [{
            type: "video/youtube",
            src: "https://www.youtube.com/watch?v=EkU4xR20Xro"
        }],
        poster: "/static/img/backgrounds/feature-video.jpg"
    },
  }),

  created () {
        AOS.init()
    },
    

  computed:{ 
        ...mapGetters({
            authenticated: 'auth/check'
        }),
        player() {
            return this.$refs.videoPlayer.player
        }
    },
  mounted(){
    this.playerOptions.poster = this.baseUrl + '/asset/img/bg/introduceVideoCoverImage.png'
  },
  methods:{
      getStart(){
          this.$router.push({path:'/login'})
      },
      openVideoPlayModal(){
          this.videoPlayModal = true;
      }
  }
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}
</style>
