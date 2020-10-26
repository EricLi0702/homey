import axios from 'axios'

function fetchUserRole () {
    return axios.get('/api/userRole')
}

function addUserRole(payload){
    return axios.post('/api/userRole',payload)
}

function updateUserRole(payload){
    return axios.put('/api/userRole',payload)
}

function delUserRole(payload){
    return axios.delete('/api/userRole',{data:payload})
}

export{
    fetchUserRole,
    addUserRole,
    updateUserRole,
    delUserRole
}