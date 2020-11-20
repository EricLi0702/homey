import axios from 'axios'

function getAptLists(){
   return axios.get('/api/apartment')
}

function addApt(payload){
    return axios.post('/api/apartment',payload)
}

function updateApt(payload){
    return axios.put('/api/apartment',payload)
}

function delApt(payload){
    return axios.delete('/api/apartment',{data: payload})
}

function addSuperMng(payload){
    return axios.post('/api/superMng',payload)
}

function getBuildingList(payload){
    let id = {
        id : payload
    }
    return axios.get('/api/aptBuilding',{params:id});
}

function addBuilding(payload){
    return axios.post('/api/aptBuilding',payload)
}
function delBuilding(payload){
    return axios.delete('/api/aptBuilding',{data: payload})
}

function updateBuilding(payload){
    return axios.put('/api/aptBuilding',payload)
}

export{
    getAptLists,
    addApt,
    updateApt,
    delApt,
    addSuperMng,
    getBuildingList,
    addBuilding,
    delBuilding,
    updateBuilding
}
