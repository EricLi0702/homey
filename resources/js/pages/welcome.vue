<template>
  <div>
    <div class="fixed-background container-fluid">
        <div class="fixed-wrap">
            <div class="fixed">  
            </div>
            <div class="h-100 d-flex text-center align-items-center justify-content-center ">
                <div class="title row m-0 p-0">
                    <div class="subtitle col-md-12 mb-5">
                        <h1>{{ $t('welcome').Vapartment }}</h1>
                    </div>
                    <div class="description col-md-12 mt-5">
                        <h4>{{ $t('welcome').WelcomeVapartment }}</h4>
                    </div>
                    <div class="btn col-md-12 mt-5">
                        <Button shape="circle" size="large" type="primary" style="height: 58px; padding: 4px 50px;" @click="getStart">{{ $t('welcome').GetStart }}</Button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content container d-flex align-items-center justify-content-center my-4">
        <div class="row m-0 p-0">
            <div class="col-md-12 col-sm-12 col-12">
                <div class="content-title col-md-12 d-flex  align-items-center justify-content-center text-center">
                    <h2 class="m-5">{{ $t('welcome').VApartmentManagementSystem }}</h2>
                </div>
            </div>
            <div class="col-md-8 col-sm-12 col-12">
                <div class="main-content col-md-12 d-flex  align-items-center justify-content-center mb-5">
                    <h5>{{ $t('welcome').LadiesAndGentleMen }}</h5>
                </div>
            </div>
            <div class="col-md-4 col-am-12 col-12">
                <div class="conten-list col-md-12 d-flex  align-items-center justify-content-center">
                    <ul class="">
                        <li>{{ $t('welcome').PrivateBalconies }}</li>
                        <li>{{ $t('welcome').AirConditioning }}</li>
                        <li>{{$t('welcome').CableReady}}</li>
                        <li>{{$t('welcome').CeilingFans}}</li>
                        <li>{{$t('welcome').StainlessSteelAppliances}}</li>
                        <li>{{$t('welcome').ExtraStorage}}</li>
                        <li>{{$t('welcome').SpaciousWalk}}</li>
                        <li>{{$t('welcome').Ceilings}}</li>
                        <li>{{$t('welcome').SpectacularViews}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="second-background container-fluid">
        <div class="second-wrap">
            <div class="second">  
            </div>
            <div class="h-100 d-flex text-center align-items-center justify-content-center ">
                <div class="attraction">
                    <div class="row p-0 m-0">
                        <div class="a-title col-md-12">
                            <h1 class="text-white">{{$t('welcome').VApartmentManagementSystem}}</h1>
                        </div>
                        <div class="a-description col-md-12 mt-5">
                            <h4 class="text-white">{{$t('welcome').VapartmentServices}}</h4>
                        </div>
                        <hr>
                        <div class="a-link col-md-12 d-flex justify-content-center mt-5">
                            <a href="#" class="mr-5">{{$t('welcome').UPDATE}}</a>
                            <a href="#" class="mr-5">{{$t('welcome').DECORATION}}</a>
                            <a href="#">{{$t('repair').repair}}</a>
                        </div>
                        <div class="a-button d-flex col-md-12 align-items-center justify-content-center text-center">
                            <Button shape="circle" size="large" type="primary" class="mt-5" style="height: 58px; padding: 4px 50px;">{{$t('welcome').ServicesDetails}}</Button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="service container">
        <div class="service-video row p-0 m-0">
            <div class="video-title col-md-12 text-center mt-5">
                <h2>V-apartment Video{{ $t('welcome').Vapartment }}</h2>
            </div>
            <div class="video-intro col-md-12 mt-5">
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" :src="`${baseUrl}/asset/video/bgvideo.mp4`" allowfullscreen></iframe>
                </div>
            </div>
            <div class="service-detail col-md-12 mt-5 row p-0 m-0">
                <div class="detail-title col-md-12 d-flex justify-content-center align-items-center text-center row p-0 m-0">
                    <h2>{{$t('welcome').OtherFeatures}}</h2>
                </div>
                <div class="col-md-8 d-flex row p-0 mt-5 mx-auto mb-5">
                    <div class="service-list col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                        <ul>
                            <li>{{$t('welcome').GuestParking}}</li>
                            <li>{{$t('welcome').EasyFreewayAccess}}</li>
                            <li>{{$t('welcome').HighSpeed}}</li>
                        </ul>
                    </div>
                    <div class="service-list col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                        <ul>
                            <li>{{$t('welcome').GuestParking}}</li>
                            <li>{{$t('welcome').EasyFreewayAccess}}</li>
                            <li>{{$t('welcome').HighSpeed}}</li>
                        </ul>
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
                    <div class="join col-md-6 d-flex row p-0  text-md-left text-center align-items-center">
                        <div class="row">
                            <div class="join-title col-md-12">
                                <p class="m-0 p-0">{{$t('welcome').JoinOurCommunity}}</p>
                            </div>
                            <div class="join-content col-md-12">
                                <p>{{$t('welcome').CallOrEmail}}</p>
                            </div>
                            <div class="join-button col-md-12 mt-5">
                                <Button shape="circle" size="large" type="primary" style="height: 58px; padding: 4px 50px;">{{$t('welcome').JoinCommunity}}</Button>
                            </div>
                        </div>
                    </div>
                    <div class="structure col-md-6 row p-0 mt-2 animate__backInUp animate__animated ">
                        <div class="home-structure col-md-12">
                            <img :src="`${baseUrl}/asset/img/bg/room-structure.png`" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="gallery container-fluid">
        <div class="row p-0 m-0">
            <div class="gallery-title col-md-12 d-flex text-center mt-5">
                <h2 class="col-md-12 m-0 p-0">{{$t('welcome').GALLERY}}</h2> 
            </div>
            <div class="gallery-content col-md-12 d-flex text-center mt-5">
                <p class="col-md-12 m-0 p-0">{{$t('welcome').OnlinePhots}}</p>
            </div>
        </div>
        <section id="gallery">
            <div class="container-fluid">
              <div id="image-gallery">
                <div class="row">
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room12.png"><img :src="`${baseUrl}/asset/img/bg/room1.jpg`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Bedroom</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room12.png"><img :src="`${baseUrl}/asset/img/bg/room4.png`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Bedroom</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room12.png"><img :src="`${baseUrl}/asset/img/bg/room3.jpg`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Bedroom</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room12.png"><img :src="`${baseUrl}/asset/img/bg/room2.jpg`" class="img-responsive"></a>
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
    <div class="container-fluid mt-5">
        <div class="row p-0 m-0">
            <div class="add-title col-md-12 row p-0 m-0">
                <h2 class="col-md-12 d-flex align-items-center justify-content-center row p-0 m-0 text-warning">Apartment Living{{ $t('welcome').Vapartment }}</h2>
            </div>
            <div class="add-content col-md-12 row p-0 mt-5">
                <p class="col-md-4 offset-md-4 text-center mb-5">{{$t('welcome').Spectrum}}</p>
            </div>
        </div>
    </div>
    <GmapMap
      :center="{lat:51.508742, lng:-0.120850}"
      :zoom="7"
      map-type-id="terrain"
      style="width: 100%; height: 300px"
    >
    </GmapMap>
  
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import GoogleMapLoader from '~/components/GoogleMapLoader'

export default {

  layout: 'default',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName,
    baseUrl:window.base_url,
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  }),
  mounted(){
    
  },
  methods:{
      getStart(){
          this.$router.push({path:'/login'})
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
