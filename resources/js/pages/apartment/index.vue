<template>
  <div class="container mt-7">
      <router-view></router-view>
  </div>
</template>

<script>
import {getAptLists} from '~/api/apartment'
export default {
  middleware: 'admin',
  data(){
    return{
      aptList:[],
      selApt:'',
    }
  },
  mounted(){

  }
}
</script>

<style>

</style>