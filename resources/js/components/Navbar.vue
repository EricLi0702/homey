<template>
  <nav class="navbar navbar-dark navbar-scroll fixed-top">
    <div class="container p-0">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
          <button class="navbar-toggler" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="navbar-toggler-icon" />
          </button>
          <div class="dropdown-menu position-absolute bg-blue-gradient animate__animated animate__fadeIn">
            <ul class="navbar-nav flex-column">
              <div v-if="user !== null">
                <router-link v-if="user.roleId == 1" :to="{ path:'/UserRole' }" class="nav-item dropdown-item" active-class="active">
                  {{ $t('common').userRole }}
                </router-link>
                <div v-if="user.roleId == 1" class="dropdown-divider" />

                <router-link v-if="user.roleId == 1" :to="{ path: '/apartment' }" class="nav-item dropdown-item" active-class="active">
                  {{ $t('common').apartment }}
                </router-link>
                <div v-if="user.roleId == 1" class="dropdown-divider" />

                <router-link v-if="user.roleId == 2" :to="{ path:'/user' }" class="nav-item dropdown-item" active-class="active">
                  {{ $t('common').user }}
                </router-link>
                <div v-if="user.roleId == 2" class="dropdown-divider" />
              </div>
              <router-link :to="{ name: 'notification' }" class="nav-item dropdown-item" active-class="active">
                <!-- {{ $t('register') }} -->
                Notification
              </router-link>
              <div class="dropdown-divider" />

              <router-link :to="{ name: 'community' }" class="nav-item dropdown-item" active-class="active">
                <!-- {{ $t('register') }} -->
                Community
              </router-link>
              <div class="dropdown-divider" />

              <router-link :to="{ name: 'suggestion' }" class="nav-item dropdown-item" active-class="active">
                <!-- {{ $t('register') }} -->
                Suggestion
              </router-link>
              <div class="dropdown-divider" />

              <router-link :to="{ name: 'repair' }" class="nav-item dropdown-item" active-class="active">
                <!-- {{ $t('register') }} -->
                Repair
              </router-link>
              <div class="dropdown-divider" />
              
              <router-link :to="{ name: 'facility' }" class="nav-item dropdown-item" active-class="active">
                <!-- {{ $t('register') }} -->
                Facility
              </router-link>
            </ul>
          </div>
        </li>
      </ul>
      <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand mx-auto">
        <img :src="`${baseUrl}/asset/img/icon/logo.png`" alt="">
      </router-link>
      <ul class="navbar-nav ml-auto">
        <locale-dropdown />
        <li class="mr-2 d-flex align-items-center ml-3">
          <Badge :count="1">
            <Icon size="30" color="#ffffff" type="md-notifications" />
          </Badge>
        </li>
        <!-- Authenticated -->
        <li v-if="user" class="nav-item dropdown mx-3">
          <a class="nav-link dropdown-toggle text-dark"
              href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
          >
            <!-- <img :src="user.photo_url" class="rounded-circle profile-photo mr-1"> -->
            <img :src="`${baseUrl}/asset/img/icon/avatar.png`" class="rounded-circle profile-photo mr-1" alt="">
            <!-- <img src="https://i.pravatar.cc/40" alt="" style="border-radius: 50%;"> -->
           
          </a>
          <div class="dropdown-menu position-absolute bg-blue-gradient animate__animated animate__fadeIn">
            <div class="p-3 text-center">
              <img :src="user.photo_url" class="rounded-circle profile-photo">
              <p>{{ user.name }}</p>
            </div>
            <div class="dropdown-divider" />
            <router-link :to="{ name: 'settings.profile' }" class="dropdown-item pl-3">
              <fa icon="cog" fixed-width />
              {{ $t('settings') }}
            </router-link>
            <div class="dropdown-divider" />
            <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
              <fa icon="sign-out-alt" fixed-width />
              {{ $t('logout') }}
            </a>
          </div>
        </li>
        <!-- Guest -->
        <template v-else>
          <li class="nav-item mx-3">
            <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
              {{ $t('login').login }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">
              {{ $t('register').register }}
            </router-link>
          </li>
        </template>
      </ul>
    </div>
  </nav>
</template>
<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'
export default {
  components: {
    LocaleDropdown
  },
  data: () => ({
    appName: window.config.appName,
    baseUrl:window.base_url
  }),
  computed: mapGetters({
    user: 'auth/user'
  }),
  mounted(){
    console.log("!!!!", this.user);
    this.listenNewNotification();
    this.listenNewSuggestion();
  },
  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')
      // Redirect to login.
      this.$router.push({ name: 'login' })
    },

    listenNewNotification(){
      Echo.private('notification')
          .listen('NewNotification', (newNotification) => {
              console.log("wow, greate!!",newNotification);
              // this.$store.commit('setNewNotificationCnt', this.getCurrentUser.new_noti_cnt + 1);
              // this.notificationList.unshift(newNotification.notification);
              // Notification.requestPermission( permission => {
              //     let notification = new Notification('New post alert!', {
              //         body: newNotification.notification.title, // content for the alert
              //         icon: "http://127.0.0.1:8000/images/icons/mainPage-phone.png" // optional image url
              //     });

              //     // link to page on clicking the notification
              //     notification.onclick = () => {
              //         window.open(window.location.href);
              //     };
              // });
              // const res = this.callApi('post','/api/users/newVideoCount',{new_video_cnt:this.$store.state.user.new_video_cnt});
          });
    },

    listenNewSuggestion(){
      Echo.private('suggestion')
          .listen('NewSuggestion', (newSuggestion) => {
              console.log("wow, greate!!",newSuggestion);
              // this.$store.commit('setNewNotificationCnt', this.getCurrentUser.new_noti_cnt + 1);
              // this.notificationList.unshift(newNotification.notification);
              // Notification.requestPermission( permission => {
              //     let notification = new Notification('New post alert!', {
              //         body: newNotification.notification.title, // content for the alert
              //         icon: "http://127.0.0.1:8000/images/icons/mainPage-phone.png" // optional image url
              //     });

              //     // link to page on clicking the notification
              //     notification.onclick = () => {
              //         window.open(window.location.href);
              //     };
              // });
              // const res = this.callApi('post','/api/users/newVideoCount',{new_video_cnt:this.$store.state.user.new_video_cnt});
          });
    },
  }
}
</script>
<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
.hamburger {
  height: 1rem;
  width: 2rem;
  display: inline-block;
  margin: 0 auto;
  cursor: pointer;
  position: relative;
}
.hamburger .bar {
  border-bottom: 0.23rem solid white;
  position: absolute;
  display: block;
  width: 100%;
  transition: all 350ms;
  transition-timing-function: cubic-bezier(1, 0.05, 0.62, 1.78);
}
.hamburger .bar:first-of-type {
  top: 0;
}
.hamburger .bar:nth-of-type(2) {
  top: 0.6rem;
}
.hamburger .bar:nth-of-type(3) {
  top: 1.2rem;
}

.opened .bar:first-of-type {
  top: 1em;
  transform: rotate(45deg);
}
.opened .bar:nth-of-type(2) {
  opacity: 0;
  transform: translateX(-30px);
}
.opened .bar:nth-of-type(3) {
  top: 1em;
  transform: rotate(-45deg);
}
</style>