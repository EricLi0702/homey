<template>
  <nav class="navbar navbar-dark navbar-scroll fixed-top">
    <div class="container">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
          <button class="navbar-toggler" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="navbar-toggler-icon" />
          </button>
          <div class="dropdown-menu position-absolute">
            <ul class="navbar-nav flex-column">
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
              <router-link :to="{ name: 'facillity' }" class="nav-item dropdown-item" active-class="active">
                <!-- {{ $t('register') }} -->
                Facillity
              </router-link>
            </ul>
          </div>
        </li>
      </ul>
      <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand mx-auto">
        <img :src="`${baseUrl}/asset/img/icon/logo.png`" alt="">
      </router-link>
      <ul class="navbar-nav ml-auto">
        <!-- <li>
          <Icon size="25" color="#FF5E14" type="md-notifications" />
        </li> -->
        <locale-dropdown />
        <!-- Authenticated -->
        <li v-if="user" class="nav-item dropdown mx-3">
          <a class="nav-link dropdown-toggle text-dark"
              href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
          >
            <img :src="user.photo_url" class="rounded-circle profile-photo mr-1">
            {{ user.name }}
          </a>
          <div class="dropdown-menu position-absolute">
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
  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')
      // Redirect to login.
      this.$router.push({ name: 'login' })
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
</style>