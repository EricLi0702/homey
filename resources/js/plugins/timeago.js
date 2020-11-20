import Vue from 'vue'

import VueTimeago from 'vue-timeago'
Vue.use(VueTimeago, {
    name: "Timeago", // Component name, `Timeago` by default
    locale: "en", // Default locale
    locales: {
      'en': require('date-fns/locale/en'),
      'kr': require('date-fns/locale/ko'),
      'vn': require('date-fns/locale/vi')
    }
  })
