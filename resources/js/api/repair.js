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

function responseToRepairRequest(responseData, repairData){
    var obj = {};
    obj['responseData'] = responseData;
    obj['repairData'] = repairData;
    return axios.post('/api/repair/response', obj );
}

function updateRepair(payload){
    return axios.put('/api/apartment',payload)
}

function deleteRequest(payload){
    return axios.delete('/api/repair',{data: payload})
}

function finishRequest(payload){
    return axios.post('/api/repair/finish',payload)
}

function getTop5Repair(userId){
    return axios.get('/api/top5Repair',{params:{id:userId}})
}

function getRepairCnt(userId){
    return axios.get('/api/repairCnt',{params:{id:userId}})
}

function getFirstItem(){
    return axios.get('/api/repair/first')
}
function getLastItem(){
    return axios.get('/api/repair/last')
}
function getPreviousItem(repairId){
    return axios.get('/api/repair/previous', {params:{id:repairId}})
}
function getNextItem(repairId){
    return axios.get('/api/repair/next', {params:{id:repairId}})
}


export{
    getRepairList,
    registerRepair,
    getCurrentRepairFromServer,
    updateRepair,
    deleteRequest,
    responseToRepairRequest,
    finishRequest,
    getTop5Repair,
    getRepairCnt,
    getFirstItem,
    getLastItem,
    getPreviousItem,
    getNextItem,
}
