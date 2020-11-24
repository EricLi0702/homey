<template>
<div class="container-fluid bg-light-gray m-0 p-0">
        <div class="notification-sub-menu container-fluid bg-white box-block">
            <div class="container d-flex justify-content-between p-0 py-3 row m-0 mx-auto">
                <Input class="col-12 col-md-6 p-0"
                 search :placeholder="$t('placeholder').enterSearchWord" />
                <div class="notification-sub-menu-items col-12 col-md-6 p-0 text-right">
                    <router-link :to="{ name: 'settings.profile' }" class="">
                        <Button type="primary" icon="md-person">{{ $t('setting').Profile }}</Button>
                    </router-link>
                    <router-link :to="{ name: 'settings.password' }" class="">
                        <Button type="warning" icon="md-key">{{ $t('setting').Password }}</Button>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="container p-0 mb-3">
            <Breadcrumb />
        </div>
        <transition name="fade" mode="out-in">
          <router-view></router-view>
        </transition>
    </div>
  
  
</template>

<script>
import Breadcrumb from '~/components/Breadcrumb'
export default {
  
  middleware: 'auth',
  components:{
    Breadcrumb,
  },
  computed: {
    tabs () {
      return [
        {
          icon: 'user',
          name: this.$t('profile'),
          route: 'settings.profile'
        },
        {
          icon: 'lock',
          name: this.$t('password'),
          route: 'settings.password'
        }
      ]
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
