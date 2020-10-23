<template>
  <div class="main-layout">
    <navbar />

    <div class="container-fluid mt-navbar p-0">
      <child />
      <Footer />
    </div>
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
  }
}
</script>
