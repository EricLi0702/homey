<template>
  <nav class="navbar navbar-dark navbar-scroll fixed-top">
    <div class="container p-0">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
          <!-- <button class="navbar-toggler" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="navbar-toggler-icon" />
          </button> -->
          <Icon @click="openMenu" size="25" type="md-menu" class="open-draw-icon"/>
          <Drawer placement="left" :closable="false" v-model="isOpenMenu" class-name="hamburger-menu-left">
            <slot name="header">
              <div @click="navigateToHome" class="w-100 text-center p-4">
                <img :src="`${baseUrl}/asset/img/icon/logo.png`" alt="" class="brand mx-auto">
              </div>
            </slot>
            <div v-if="user !== null">
              <div v-if="user.roleId == 1" @click="navigateToRouterLink('UserRole')" :class="{ active : active_el == 'UserRole' }" class="d-flex m-1 p-2 drawer-menu-item">
                <Icon size="25" class="mr-1" type="md-man" />
                {{ $t('common').userRole }}
              </div>
              <div v-if="user.roleId == 1" @click="navigateToRouterLink('adminuser')" :class="{ active : active_el == 'adminuser' }" class="d-flex m-1 p-2 drawer-menu-item">
                <Icon size="25" class="mr-1" type="md-people" />
                {{ $t('apartment').User }}
              </div>
              <div v-if="user.roleId == 1" @click="navigateToRouterLink('apartment')" :class="{ active : active_el == 'apartment' }" class="d-flex m-1 p-2 drawer-menu-item">
                <Icon size="25" class="mr-1" type="md-home" />
              {{$t('apartment').Apartment}}
              </div>
              <div v-if="user.roleId == 2" @click="navigateToRouterLink('user')" :class="{ active : active_el == 'user' }" class="d-flex m-1 p-2 drawer-menu-item">
                <Icon size="25" class="mr-1" type="md-people" />
                {{$t('apartment').User}}
              </div>
              <div v-if="user.roleId == 2" @click="navigateToRouterLink('building')" :class="{ active : active_el == 'building' }" class="d-flex m-1 p-2 drawer-menu-item">
                <Icon size="25" class="mr-1" type="md-home" />
                 {{$t('apartment').building}}
              </div>
            </div>
            <div @click="navigateToRouterLink('notification')" :class="{ active : active_el == 'notification' }" class="d-flex m-1 p-2 drawer-menu-item">
              <Icon size="25" class="mr-1" type="ios-clipboard-outline" />
              {{$t('notification').notification}}
            </div>
            <div @click="navigateToRouterLink('community')" :class="{ active : active_el == 'community' }" class="d-flex m-1 p-2 drawer-menu-item">
              <Icon size="25" class="mr-1" type="ios-people" />
              {{$t('community').cummunity}}
            </div>
            <div @click="navigateToRouterLink('facility')" :class="{ active : active_el == 'facility' }" class="d-flex m-1 p-2 drawer-menu-item">
              <Icon size="25" class="mr-1" type="md-share" />
              {{$t('welcome').PublicFacility}}
            </div>
            <div @click="navigateToRouterLink('suggestion')" :class="{ active : active_el == 'suggestion' }" class="d-flex m-1 p-2 drawer-menu-item">
              <Icon size="25" class="mr-1" type="md-chatbubbles" />
              {{$t('welcome').suggestion}}
            </div>
            <div @click="navigateToRouterLink('repair')" :class="{ active : active_el == 'repair' }" class="d-flex m-1 p-2 drawer-menu-item">
              <Icon size="25" class="mr-1" type="ios-construct" />
              {{$t('repair').repairRequest}}
            </div>
            
            <!-- <img :src="`${baseUrl}/asset/img/bg/introducerGuide.png`" alt="" class="drawer-img"> -->
          </Drawer>
        </li>
      </ul>
      <div @click="navigateToHome" class="navbar-brand mx-auto">
        <img :src="`${baseUrl}/asset/img/icon/logo1.png`" alt="">
      </div>
      <ul class="navbar-nav ml-auto d-flex align-items-center">
        <locale-dropdown />
        <li v-if="user" class="mr-2 d-flex align-items-center ml-3 nav-item">
          <Badge :count="pushNotificationCnt">
            <Icon size="30" color="#ffffff" type="md-notifications" class="navbar-notification-icon nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"/>
            <div class="dropdown-menu position-absolute bg-blue-gradient animate__animated animate__fadeIn mt-1rem newpush-dropdown-menu">
              <ul class="navbar-nav flex-column">
                <div v-if="user !== null">
                  <div v-if="pushNotificationCnt == 0">
                    <div class="nav-item dropdown-item d-flex" active-class="active">
                      <Icon size="25" class="mr-1" type="md-beer" />
                    </div>
                  </div>
                  <div v-else>
                    <div v-if="pushNotification.notification && pushNotification.notification.length >0">
                      <div class="dropdown-divider" />
                      <div @click="removeNotificationFromNew(notification)" v-for="(notification,i) in pushNotification.notification" :key="i" class="nav-item dropdown-item d-flex align-items-center mt-2" active-class="active">
                        <img :src="`${baseUrl}${notification.userAvatar}`" class="rounded-circle profile-photo mr-1" alt="">
                        <Icon class="mr-1" type="ios-clipboard" />
                        <p class="newpush-dropdown-p">{{notification.title}}</p>
                      </div>
                    </div>
                    <div v-if="pushNotification.suggestion && pushNotification.suggestion.length >0">
                      <div class="dropdown-divider" />
                      <div @click="removeSuggestionFromNew(suggestion)" v-for="(suggestion,i) in pushNotification.suggestion" :key="i" :to="{ path:`/suggestion/${suggestion.id}` }" class="nav-item dropdown-item d-flex align-items-center mt-2" active-class="active">
                      <img :src="`${baseUrl}${suggestion.userAvatar}`" class="rounded-circle profile-photo mr-1" alt="">
                        <Icon class="mr-1" type="md-chatbubbles" />
                        <p class="newpush-dropdown-p">{{suggestion.title}}</p>
                      </div>
                    </div>
                    <div v-if="pushNotification.community && pushNotification.community.length >0">
                      <div class="dropdown-divider" />
                      <div @click="removeCommunityFromNew(community)" v-for="(community,i) in pushNotification.community" :key="i" :to="{ path:`/community/${community.id}` }" class="nav-item dropdown-item d-flex align-items-center mt-2" active-class="active">
                      <img :src="`${baseUrl}${community.userAvatar}`" class="rounded-circle profile-photo mr-1" alt="">
                        <Icon class="mr-1" type="ios-people" />
                        <p class="newpush-dropdown-p">{{community.title}}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </ul>
            </div>
          </Badge>
        </li>
        <!-- Authenticated -->
        <li v-if="user" class="nav-item dropdown mx-3">
          <a class="nav-link dropdown-toggle text-dark"
              href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
          >
            <img :src="`${baseUrl}${user.user_avatar}`" class="rounded-circle profile-photo mr-1" alt="">
          </a>
          <div class="dropdown-menu position-absolute bg-blue-gradient animate__animated animate__fadeIn mt-1rem">
            <div class="pt-3 text-center">
              <img :src="`${baseUrl}${user.user_avatar}`" class="rounded-circle profile-photo menu-profile-photo">
              <p class="dropdown-item">{{ user.name }}</p>
            </div>
            <div class="dropdown-divider" />
            <router-link :to="{ name: 'settings.profile' }" class="dropdown-item pl-3">
              <fa icon="cog" fixed-width />
              {{ $t('common').setting }}
            </router-link>
            <div class="dropdown-divider" />
            <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
              <fa icon="sign-out-alt" fixed-width />
              {{ $t('common').logout }}
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
import {
  newPush, 
  getNewPush, 
  removeNotificationFromNewGroup,
  removeSuggestionFromNewGroup,
  removeCommunityFromNewGroup,
} from '~/api/push'
export default {
  components: {
    LocaleDropdown
  },
  data: () => ({
    appName: window.config.appName,
    baseUrl:window.base_url,
    pushNotification:{
      notification:[],
      community:[],
      suggestion:[]
    },
    pushNotificationCnt: 0,
    isOpenMenu:false,
    active_el: '',
  }),
  computed: mapGetters({
    user: 'auth/user'
  }),
  created(){
    this.getNewPush();
  },
  mounted(){
    this.listenNewNotification();
    this.listenNewSuggestion();
    this.listenNewCommunity();
  },
  // watch:{
  //   $route(to,from){
  //         this.$router.go()
  //     }
  // },

  methods: {
    navigateToHome(){
      if(this.user == null){
        this.isOpenMenu = false;
        this.active_el = '';
        this.$router.push({ name: 'welcome' })
      }
      else{
        this.isOpenMenu = false;
        this.active_el = '';
        this.$router.push({ name: 'home' })
      }
    },
    navigateToRouterLink(path){
      this.active_el = path;
      this.isOpenMenu = false;
      this.$router.push({ path: `/${path}` })
    },
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')
      // Redirect to login.
      this.$router.push({ name: 'login' })
    },

    getNewPush(){
      getNewPush()
      .then(res=>{
        if(res.data.pushData ==  null){
          this.pushNotificationCnt = 0;
        }
        else{
          this.pushNotification = JSON.parse(res.data.pushData);
          this.pushNotificationCnt = this.pushNotification.notification.length + this.pushNotification.community.length + this.pushNotification.suggestion.length;
        }
      })
      .catch(err=>{

      })
    },
    removeNotificationFromNew(notification){
      this.pushNotification.notification.pop(notification);
      this.pushNotificationCnt--;
      let updatePushData = {}
      updatePushData.postUpdatePushData = this.pushNotification;
      removeNotificationFromNewGroup(updatePushData)
      .then(res=>{
        this.$router.push({ path:`/notification/${notification.id}` })
      })
      .catch(err=>{
        console.log(err);
      })
    },
    removeSuggestionFromNew(suggestion){
      this.pushNotification.suggestion.pop(suggestion);
      this.pushNotificationCnt--;
      let updatePushData = {}
      updatePushData.postUpdatePushData = this.pushNotification;
      removeNotificationFromNewGroup(updatePushData)
      .then(res=>{
        this.$router.push({ path:`/suggestion/${suggestion.id}` })
      })
      .catch(err=>{
        console.log(err);
      })
    },
    removeCommunityFromNew(community){
      this.pushNotification.community.pop(community);
      this.pushNotificationCnt--;
      let updatePushData = {}
      updatePushData.postUpdatePushData = this.pushNotification;
      removeNotificationFromNewGroup(updatePushData)
      .then(res=>{
        this.$router.push({ path:`/community/${community.id}` })
      })
      .catch(err=>{
        console.log(err);
      })
    },

    listenNewNotification(){
      Echo.channel('notification')
          .listen('NewNotification', (newNotification) => {
              if(newNotification.notification.userId == this.user.id){
                return;
              }
              this.pushNotification.notification.push(newNotification.notification);
              this.pushNotificationCnt++;
              let newPushData = {}
              newPushData.postNewPushData = this.pushNotification;
              newPush(newPushData)
              .then(res=>{
              })
              .catch(err=>{

              })
          });
    },

    listenNewSuggestion(){
      Echo.channel('suggestion')
          .listen('NewSuggestion', (newSuggestion) => {
              if(newSuggestion.suggestion.userId == this.user.id){
                return;
              }
              this.pushNotification.suggestion.push(newSuggestion.suggestion);
              this.pushNotificationCnt++;
              let newPushData = {}
              newPushData.postNewPushData = this.pushNotification;
              newPush(newPushData)
              .then(res=>{
              })
              .catch(err=>{
              })
          });
    },
    listenNewCommunity(){
      Echo.channel('community')
          .listen('NewCommunity', (newCommunity) => {
              if(newCommunity.community.userId == this.user.id){
                return;
              }
              this.pushNotification.community.push(newCommunity.community);
              this.pushNotificationCnt++;
              let newPushData = {}
              newPushData.postNewPushData = this.pushNotification;
              newPush(newPushData)
              .then(res=>{
              })
              .catch(err=>{
              })
          });
    },

    openMenu(){
      let heightOfDevice = $(window).height();
      
      let drawerItem = $('.ivu-drawer-content');
      let drawerBody = $('.ivu-drawer-body');
      if ($('.navbar').hasClass('navbar-scroll')) {
        drawerItem.removeClass('scroll-drawer');
        drawerItem.addClass('top-drawer');
        let heightOfMenuDrawer = heightOfDevice - 86.78;
        drawerBody.css("height", `${heightOfMenuDrawer}px`);
        drawerBody.css("overflow", 'auto');

      }
      else{
        drawerItem.addClass('scroll-drawer');
        drawerItem.removeClass('top-drawer');
        let heightOfMenuDrawer = heightOfDevice - 66.78;
        drawerBody.css("height", `${heightOfMenuDrawer}px`);
        drawerBody.css("overflow", 'auto');

      }
      this.isOpenMenu = !this.isOpenMenu;
    }
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