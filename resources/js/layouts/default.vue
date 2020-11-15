<template>
  <div class="main-layout">
      <navbar v-if="checkComponent"/>

    <div class="container-fluid mt-navbar p-0">
      <child />
      <Footer />
    </div>

    <BackTop></BackTop>
  </div>
  
</template>

<script>
import Navbar from '~/components/Navbar'
import Footer from '~/components/Footer'

export default {
  name: 'MainLayout',

  components: {
    Navbar,
    Footer
  },
  computed:{
    checkComponent(){
      if(this.$route.name == "welcomeMobile"){
        let mtNavbar = $('.mt-navbar');
        mtNavbar.removeClass('mt-navbar');
        return false;
      }
      else{
        return true;
      }
    },      
  },
}
</script>
