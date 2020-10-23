<template>
  <card :title="$t('home')">
    {{ $t('you_are_logged_in') }}
    <!-- <fetch-users></fetch-users> -->
    <Button type="primary">test</Button>
  </card>
</template>

<script>
// import FetchUsers from '~/components/FetchUsers'
import {mapGetters} from 'vuex'
export default {
  // components: {
  //   FetchUsers,
  // },
  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('home') }
  },
  data(){
    return{
      islogin:true
    }
  },
  computed:{
    ...mapGetters({
      currentUser:'auth/user'
    })
  },
  mounted(){
    console.log(this.currentUser)
  }
}
</script>
