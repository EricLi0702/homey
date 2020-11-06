import axios from 'axios'

function newPush(payload){
    return axios.post('/api/newPush',payload)
}

function getNewPush(){
    return axios.get('/api/newPush')
}

export{
    newPush,
    getNewPush,
}