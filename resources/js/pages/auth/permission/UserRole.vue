<template>
    <div class="container-fluid bg-light-gray m-0 py-3 pb-5 bg-wallpaper">
      <div class="container p-0 mb-3">
          <Breadcrumb />
      </div>
    <div class="suggestion-sub-menu container box-block overflow-auto mb-0">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Breadcrumb from '~/components/Breadcrumb'
export default {
    middleware:'admin',
    components:{
        Breadcrumb,
    },
}
</script>