import store from '~/store'
import router from '../router'

export default (to, from, next) => {
  if ((store.getters['auth/user'].role.roleName !== 'SystemAdmin') || 
      (store.getters['auth/user'].role.roleName !== 'SuperManager')) {
    console.log('permission error')
    router.push({path: '/home'})
  } else {
    next()
  }
}
