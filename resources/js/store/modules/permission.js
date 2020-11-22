import * as types from '../mutation-types'
import {fetchUserRole,addUserRole} from '../../api/permission'

// state
export const state = {
  roleList:null,
}

// getters
export const getters = {
    
}

//mutations
export const mutations = {
  [types.ROLE_LIST] (state, { roleList }) {
      state.roleList = roleList
  }
}

// actions

export const actions = {
    fetchUserRole( {commit} ){
        fetchUserRole()
            .then(res=>{
                const { data } = res.data
                commit(types.ROLE_LIST, { roleList: data })
            })
            .catch(err=>{

            })
    },
    addUserRole ( { commit }, payload ){
        addUserRole(payload)
            .then(res=>{
            })
            .catch(err=>{
                console.log(err)
            })

    }
}  