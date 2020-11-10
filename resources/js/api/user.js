import axios from 'axios'

function getUserList(page){
    return axios.get('/api/users?page=' + page)
}

function addUser(payload){
    return axios.post('/api/users',payload)
}

function updateUser(payload){
    return axios.put('/api/users',payload)
}

function delUser(payload){
    let obj = {
        id: payload
    }
    return axios.delete('/api/users',{data: obj})
}

export{
    getUserList,
    addUser,
    delUser,
    updateUser,
}