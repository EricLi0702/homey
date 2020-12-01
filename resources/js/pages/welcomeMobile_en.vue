<template>
  <div>
    <div class="fixed-background container-fluid">
        <div class="fixed-wrap">
            <div class="fixed">  
            </div>
            <div class="h-100 d-flex text-center align-items-center justify-content-center ">
                <div class="title row m-0 p-0">
                    <div class="subtitle col-md-12 mb-5" data-aos="zoom-out">
                        <h1>The Link 345</h1>
                    </div>
                    <div class="description mt-5 container" data-aos="fade-up">
                        <h4>The Link 345 is an apartment located in the center of Hanoi that provides a pleasant living environment.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content container d-flex align-items-center justify-content-center my-4 pt-4" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
        <div class="row m-0 p-0">
            <div class="col-12 text-center mb-3">
                <h2 class="section-title">Greeting of The Link 345</h2>
            </div>
            <div class="col-12 mb-2">
                <div class="main-content col-md-12 d-flex  align-items-center justify-content-center mb-5">
                    <read-more more-str="read more" text="Hello residents, this apartment has now opened an apartment application service to offer better life. We will make apartments better only for residents with transparency and sincerity. We hope that new service will get close to all residents as quickly as possible. And resident can also communicate  each other more than before. Our management office will do the best for our resident. We sincerely wish your peace and happiness The Link 345 Thank you. " link="#" less-str="read less" :max-chars="150"></read-more>
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
                            <h2 class="section-title">The management office in The Link 345</h2>
                        </div>
                        <p class="col-md-6 offset-md-3 col-8 offset-2 pt-2">Please feel free to contact us! The Link 345 is always by your side. </p>
                        <hr>
                        <div class="container d-flex justify-content-between mt-5">
                            <p class="">Management Office  1900-3432</p>
                            <p class="">R1 1900-1122</p>
                            <p>R2 1900-3829</p>
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
                                    <p>total units</p>
                                </div>
                                <div class="col-9">
                                    582
                                    <!-- <p>{{$t('welcome').APTdetail_detail_1}}</p> -->
                                </div>
                            </div>
                            <div class="row w-100 m-0">
                                <div class="col-3">
                                    <p>occupancy date</p>
                                </div>
                                <div class="col-9">
                                    <p>2018 Q4</p>
                                </div>
                            </div>
                            <div class="row w-100 m-0">
                                <div class="col-3">
                                    <p>Developer</p>
                                </div>
                                <div class="col-9">
                                    <p>Ciputra Real Estate Development Investment Group & Hanoi Urban Infrastructure Development Corporation </p>
                                </div>
                            </div>
                            <div class="row w-100 m-0">
                                <div class="col-3">
                                    <p>Building</p>
                                </div>
                                <div class="col-9">
                                    <p>3 (L3, L4, L5)</p>
                                </div>
                            </div>
                            <div class="row w-100 m-0">
                                <div class="col-3">
                                    <p>Floor</p>
                                </div>
                                <div class="col-9">
                                    <p>32</p>
                                </div>
                            </div>
                            <div class="row w-100 m-0">
                                <div class="col-3">
                                    <p>Unit Size</p>
                                </div>
                                <div class="col-9">
                                    <p>57m2~153m2</p>
                                </div>
                            </div>
                            <div class="row w-100 m-0">
                                <div class="col-3">
                                    <p>facilities</p>
                                </div>
                                <div class="col-9">
                                    <p>Tennis court, Pool, GYM, Golf, BBQ</p>
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
                <h2 class="col-md-12 m-0 p-0 section-title">Facilities of The Link 345</h2> 
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
                <h2 class="col-md-12 d-flex align-items-center justify-content-center row p-0 m-0 section-title">The Link 345 Location</h2>
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

    <footer class="footer-section">
        <div class="container">
            <div class="footer-cta pt-5 pb-5">
                <div class="row d-flex p-0 m-0 ">
                    <div class="col-12 m-0 p-0 mb-3">
                        <h1 class="text-bold text-white">The Link 345</h1>
                    </div>
                    <div class="col-xl-6 col-md-6 mb-30 p-0">
                        <div class="single-cta d-flex justify-content-start align-items-start ">
                            <Icon type="md-locate" color="#FF5E14" size="30"/>
                            <div class="cta-text">
                                <h4>Find us</h4>
                                <span>Lô đất IC 32, Khu Đô Thị Nam Thăng Long,  Tây Hồ, Hà Nội</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 mb-30 p-0 pl-md-2">
                        <div class="single-cta d-flex justify-content-start align-items-start">
                            <Icon type="ios-phone-portrait" color="#FF5E14" size="30" />
                            <div class="cta-text">
                                <h4>Call us</h4>
                                <span>0243-758-2126, 1900-1122</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-content pt-1 pb-1">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 mb-50">
                        <div class="footer-widget">
                            <div class="footer-logo">
                                <a href="/">
                                    <img :src="`${baseUrl}/asset/img/icon/logo.png`" alt="">
                                </a>
                            </div>
                            <div class="footer-text">
                                <h3 class="text-gray">We support a happy life</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                        <div class="footer-widget">
                            <div class="single-cta d-flex justify-content-start align-items-center mb-2">
                                <Icon type="md-locate" color="#FF5E14" size="30"/>
                                <div class="cta-text">
                                    <h4>Công ty TNHH một thành viên We Apt</h4>
                                </div>
                            </div>
                            <div class="single-cta d-flex justify-content-start align-items-center mb-2">
                                <Icon type="ios-person" color="#FF5E14" size="30" />
                                <div class="cta-text">
                                    <h4>Han Sang Hoon</h4>
                                </div>
                            </div>
                            <div class="single-cta d-flex justify-content-start align-items-center mb-2">
                                <Icon type="ios-mail-open" color="#FF5E14" size="30"/>
                                <div class="cta-text">
                                    <h4>weapt2021@gmail.com</h4>
                                </div>
                            </div>
                            <div class="single-cta d-flex justify-content-start align-items-center mb-2">
                                <Icon type="ios-phone-portrait" color="#FF5E14" size="30" />
                                <div class="cta-text">
                                    <h4>+84 357 852 066</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-50 text-md-center">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <router-link :to="{ name: 'term' }">
                                    <h3>Terms of Use</h3>
                                </router-link>
                                <router-link :to="{ name: 'privacy' }">
                                    <h3>Privacy Policy</h3>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 text-center align-items-center justify-content-center">
                        <div class="copyright-text">
                            <p>Copyright &copy; HOMEY Guide All Rights Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
  
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
    return { title: this.$t('home') }
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
