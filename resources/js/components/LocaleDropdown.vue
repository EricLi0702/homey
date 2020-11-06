<template>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button"
       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
    >
      <img style="width:27px; margin:3px;" :src="`/asset/img/icon/${locales[locale]}_flag.png`" alt="" />
      {{ locales[locale] }}
    </a>
    <div class="dropdown-menu position-absolute bg-blue-gradient animate__animated animate__fadeIn mt-1rem">
      <a v-for="(value, key) in locales" :key="key" class="dropdown-item" href="#"
         @click.prevent="setLocale(key)"
      >
        <img class="navbar-flag" :src="`/asset/img/icon/${value}_flag.png`" alt="" />
        {{ value }}
      </a>
    </div>
  </li>
</template>

<script>
import { mapGetters } from 'vuex'
import { loadMessages } from '~/plugins/i18n'

export default {
  computed: mapGetters({
    locale: 'lang/locale',
    locales: 'lang/locales'
  }),

  methods: {
    setLocale (locale) {
      if (this.$i18n.locale !== locale) {
        loadMessages(locale)

        this.$store.dispatch('lang/setLocale', { locale })
      }
    }
  }
}
</script>

