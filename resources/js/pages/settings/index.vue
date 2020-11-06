<template>
<div class="container-fluid bg-light-gray m-0 p-0">
        <!-- <div class="apt-img hv-40 noti-apt-img">
        </div> -->
        <div class="notification-sub-menu container-fluid bg-white box-block">
            <div class="container d-flex justify-content-between p-0 py-3 ">
                <Input class="w-40"
                 search :placeholder=" $t('facility').EnterSomething " />
                <div class="notification-sub-menu-items">
                    <router-link :to="{ name: 'settings.profile' }" class="">
                        <!-- {{ $t('register') }} -->
                        <Button type="primary" icon="md-person">{{ $t('setting').Profile }}</Button>
                    </router-link>
                    <router-link :to="{ name: 'settings.password' }" class="">
                        <!-- {{ $t('register') }} -->
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
