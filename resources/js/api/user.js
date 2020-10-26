import axios from 'axios'

function getUserList(payload){
    return axios.get('/api/users',{params:{aptId:payload}})
}

function addUser(payload){
    return axios.post('/api/users',payload)
}

export{
    getUserList,
    addUser,
}