<template>
  <div>
    <div class="top-right links">
      <template v-if="authenticated">
        <router-link :to="{ name: 'home' }">
          {{ $t('home') }}
        </router-link>
      </template>
      <template v-else>
        <router-link :to="{ name: 'login' }">
          {{ $t('login').login }}
        </router-link>
        <router-link :to="{ name: 'register' }">
          {{ $t('register').register }}
        </router-link>
      </template>
    </div>
    <div class="fixed-background container-fluid">
        <div class="fixed-wrap">
            <div class="fixed">  
            </div>
            <div class="h-100 d-flex text-center align-items-center justify-content-center ">
                <div class="title row m-0 p-0">
                    <div class="subtitle col-md-12 mb-5">
                        <h1>Vampire Apartment</h1>
                    </div>
                    <div class="description col-md-12 mt-5">
                        <h4>Welcome to our V-apartment service system</h4>
                    </div>
                    <div class="btn col-md-12 mt-5">
                        <button class="btn btn-outline-white btn-lg mt-5" type="button">Get starteds</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content container d-flex align-items-center justify-content-center">
        <div class="row m-0 p-0">
            <div class="col-md-12 col-sm-12 col-12">
                <div class="content-title col-md-12 d-flex  align-items-center justify-content-center">
                    <h2 class="m-5">Vampire-Apartment Management System</h2>
                </div>
            </div>
            <div class="col-md-8 col-sm-12 col-12">
                <div class="main-content col-md-12 d-flex  align-items-center justify-content-center mb-5">
                    <h5>Ladies and gentle men.
                        This time our apartment has opened an apartment application for the convenience of residents. Through more transparent and clean apartment management, we will make apartments that residents can live in. Vampire-Apartment system brings luxury and convenience to your front door. Located in west Las Vegas, NV, near Spring Valley, Spectrum is ideal for those seeking comfort, those looking for a higher level in apartment elegance, and those who simply want a better apartment experience. You deserve not just a house, but a home, a community, and peace of mind. Find all those at Spectrum. Our one and two bedroom town home floor plans welcome you home with thoughtful touches, including air conditioning, spacious walk-in closets, a well-equipped kitchen, ceiling fans, and intrusion alarms.
                        Every great apartment has a great location. We ask for your generous support for the development of apartment management in the future. Dear residents who love and care for our Miding Florence, I hope you will always be healthy and happy.
                        Thank you.</h5>
                </div>
            </div>
            <div class="col-md-4 col-am-12 col-12">
                <div class="conten-list col-md-12 d-flex  align-items-center justify-content-center">
                    <ul class="">
                        <li>Private Balconies/Patios</li>
                        <li>Air conditioning</li>
                        <li>Cable Ready</li>
                        <li>Ceiling Fans</li>
                        <li>Stainless Steel Appliances</li>
                        <li>Extra Storage</li>
                        <li>Spacious Walk In Closets & strorage</li>
                        <li>9ft Ceilings</li>
                        <li>Spectacular Views Available</li>
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
                            <h1 class="text-white">Vampire-Apartement Awesome</h1>
                        </div>
                        <div class="a-description col-md-12 mt-5">
                            <h4 class="text-white">V-apartment Services</h4>
                        </div>
                        <hr>
                        <div class="a-link col-md-12 d-flex justify-content-center mt-5">
                            <a href="#" class="mr-5">UPDATE</a>
                            <a href="#" class="mr-5">DECORATION</a>
                            <a href="#">REPAIR</a>
                        </div>
                        <div class="a-button d-flex col-md-12 align-items-center justify-content-center text-center">
                            <button class="btn btn-outline-white btn-md mt-5" type="button">Services Detail</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="service container">
        <div class="service-video row p-0 m-0">
            <div class="video-title col-md-12 text-center mt-5">
                <p>V-apartment Video</p>
            </div>
            <div class="video-intro col-md-12 mt-5">
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" :src="`${baseUrl}/asset/video/bgvideo.mp4`" allowfullscreen></iframe>
                </div>
            </div>
            <div class="service-detail col-md-12 mt-5 row p-0 m-0">
                <div class="detail-title col-md-12 d-flex justify-content-center align-items-center text-center row p-0 m-0">
                    <p>Other Features & Services</p>
                </div>
                <div class="col-md-8 d-flex row p-0 mt-5 mx-auto mb-5">
                    <div class="service-list col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                        <ul>
                            <li>Guest Parking</li>
                            <li>Easy Freeway Access</li>
                            <li>High Speed Internet Available</li>
                        </ul>
                    </div>
                    <div class="service-list col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                        <ul>
                            <li>Guest Parking</li>
                            <li>Easy Freeway Access</li>
                            <li>High Speed Internet Available</li>
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
                                <p class="m-0 p-0">Join Our Community</p>
                            </div>
                            <div class="join-content col-md-12">
                                <p>Call or email us to shedule a update today. Come see your updated home and the community features in person.</p>
                            </div>
                            <div class="join-button col-md-12">
                                <button class="btn btn-outline-white btn-md mb-sm-5 mb-5">Decoration Detail</button>
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
                <p class="col-md-12 m-0 p-0">GALLERY OF VAMPIRE APARTMENTS</p> 
            </div>
            <div class="gallery-content col-md-12 d-flex text-center mt-5">
                <p class="col-md-12 m-0 p-0">Take an online Photos of our V-apartments for your requirements we can help you.</p>
            </div>
        </div>
        <section id="gallery">
            <div class="container-fluid">
              <div id="image-gallery">
                <div class="row">
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room12.png"><img :src="`${baseUrl}/asset/img/bg/room12.png`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Bedroom</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room2.png"><img :src="`${baseUrl}/asset/img/bg/room2.png`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Living room</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room3.jpg"><img :src="`${baseUrl}/asset/img/bg/room3.jpg`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Guest room</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room4.png"><img :src="`${baseUrl}/asset/img/bg/room4.png`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Dining room</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room5.png"><img :src="`${baseUrl}/asset/img/bg/room5.png`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Pool</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room6.png"><img :src="`${baseUrl}/asset/img/bg/room6.png`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Bedroom</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room7.png"><img :src="`${baseUrl}/asset/img/bg/room7.png`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Living room</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room8.png"><img :src="`${baseUrl}/asset/img/bg/room8.png`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Living room</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room9.jpg"><img :src="`${baseUrl}/asset/img/bg/room9.jpg`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Entertainment room</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/bathroom.png"><img :src="`${baseUrl}/asset/img/bg/bathroom.png`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Bathroom</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/bathroom1.png"><img :src="`${baseUrl}/asset/img/bg/bathroom1.png`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Bathroom</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/entrance.jpg"><img :src="`${baseUrl}/asset/img/bg/entrance.jpg`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Entrance</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/gym.png"><img :src="`${baseUrl}/asset/img/bg/gym.png`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Gym</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/interior.png"><img :src="`${baseUrl}/asset/img/bg/interior.png`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Balcony</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/outside.jpg"><img :src="`${baseUrl}/asset/img/bg/outside.jpg`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Outside</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/outside1.jpg"><img :src="`${baseUrl}/asset/img/bg/outside1.jpg`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Park</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/pool.png"><img :src="`${baseUrl}/asset/img/bg/pool.png`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Pool</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room1.jpg"><img :src="`${baseUrl}/asset/img/bg/room1.jpg`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Living room</p>
                        <p></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room10.png"><img :src="`${baseUrl}/asset/img/bg/room10.png`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Bedroom</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-12 image">
                    <div class="img-wrapper">
                      <a href="/asset/img/bg/room11.png"><img :src="`${baseUrl}/asset/img/bg/room11.png`" class="img-responsive"></a>
                      <div class="img-overlay">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <p>Kitchen</p>
                      </div>
                    </div>
                  </div>
                </div><!-- End row -->
              </div><!-- End image gallery -->
            </div><!-- End container --> 
          </section>    
    </div>
    <div class="container-fluid">
        <div class="row p-0 m-0">
            <div class="add-title col-md-12 row p-0 m-0">
                <p class="col-md-12 d-flex align-items-center justify-content-center row p-0 m-0">Apartment Living</p>
            </div>
            <div class="add-content col-md-12 row p-0 mt-5">
                <p class="col-md-4 offset-md-4 text-center">Living at Spectrum puts everything that you need and love close at hand. Our central location is within walking distance of two grocery stores, a pharmacy, hospital, and beltway. You'll find a different kind of living here at Spectrum--one characterized by ease and elegance.</p>
            </div>
        </div>
    </div>
    <GmapMap
      :center="{lat:10, lng:10}"
      :zoom="7"
      map-type-id="terrain"
      style="width: 500px; height: 300px"
    >
    </GmapMap>
  
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import GoogleMapLoader from '~/components/GoogleMapLoader'

export default {

  layout: 'default',


  // props: {
  //   mapConfig: {
  //     center:new google.maps.LatLng(51.508742,-0.120850),
	//     zoom:5,
  //   },
  //   apiKey: "AIzaSyBmoGr8OWrJb6AmKHeOrmS2U9z9gx7WBeQ",
  // },

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName,
    baseUrl:window.base_url,
    // google: null,
    // map: null
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  }),
  mounted(){
    
  }
  // async mounted() {
  //   const googleMapApi = await GoogleMapsApiLoader({
  //     apiKey: this.apiKey
  //   })
  //   this.google = googleMapApi
  //   this.initializeMap()
  // },

  // methods: {
  //   initializeMap() {
  //     const mapContainer = this.$refs.googleMap
  //     this.map = new this.google.maps.Map(
  //       mapContainer, this.mapConfig
  //     )
  //   }
  // }
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
