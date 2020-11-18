import axios from 'axios'
import store from '~/store'
import router from '~/router'
import Swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

// Request interceptor
axios.interceptors.request.use(request => {
  const token = store.getters['auth/token']
  if (token) {
    request.headers.common['Authorization'] = `Bearer ${token}`
  }

  const locale = store.getters['lang/locale']
  if (locale) {
    request.headers.common['Accept-Language'] = locale
  }

  // request.headers['X-Socket-Id'] = Echo.socketId()

  return request
})

// Response interceptor
axios.interceptors.response.use(response => response, error => {
  const { status } = error.response

  if (status >= 500) {
    Swal.fire({
      type: 'error',
      title: i18n.t('common').serverError,
      text: i18n.t('common').swr,
      reverseButtons: true,
      confirmButtonText: i18n.t('common').ok,
      cancelButtonText: i18n.t('common').cancel
    })
  }

  if (status === 401 && store.getters['auth/check']) {
    Swal.fire({
      type: 'warning',
      title: i18n.t('common').tokenExpired,
      text: i18n.t('common').tokenExpiredText,
      reverseButtons: true,
      confirmButtonText: i18n.t('common').ok,
      cancelButtonText: i18n.t('common').cancel
    }).then(() => {
      store.commit('auth/LOGOUT')

      router.push({ name: 'login' })
    })
  }

  return Promise.reject(error)
})
