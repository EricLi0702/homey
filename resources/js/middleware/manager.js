import store from '~/store'
import {error} from '~/helper/common'
export default (to, from, next) => {
  if (store.getters['auth/user'].role.roleName !== 'AptManager') {
    console.log('permission error')
    next({ name: from.name })
  } else {
    next()
  }
}
