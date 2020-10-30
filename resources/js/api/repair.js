import axios from 'axios'

function getRepairList(page){
    return axios.get(`/api/repair?page=${page}`)
}

function registerRepair(payload){
    return axios.post('/api/repair/create',payload)
}

function getCurrentRepairFromServer(currentId){
    return axios.get('/api/repair/current',{params: { id: currentId }});
}


function updateRepair(payload){
    return axios.put('/api/apartment',payload)
}

function delRepair(payload){
    return axios.delete('/api/apartment',payload)
}

export{
    getRepairList,
    registerRepair,
    getCurrentRepairFromServer,
    updateRepair,
    delRepair,
}
