import store from '~/store'
import {error} from '~/helper/common'
import router from '../router'

export default (to, from, next) => {
  if (store.getters['auth/user'].role.roleName !== 'SuperManager') {
    console.log('permission error')
    // next({ name: from.name })
    router.push({path: '/home'})
  } else {
    next()
  }
}
