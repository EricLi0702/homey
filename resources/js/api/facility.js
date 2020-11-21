import axios from 'axios'

function getFacilityList(){
   return axios.get('/api/facility')
}

function registerFacility(payload){
    return axios.post('/api/facility/create',payload)
}

function updateFacility(payload){
    return axios.put('/api/apartment',payload)
}

function removeSelectedFacility(payload){
    return axios.delete('/api/facility',{data: payload})
}

function changeAcceptMode(payload){
    return axios.put('/api/apartment/auto',payload)
}

export{
    getFacilityList,
    registerFacility,
    updateFacility,
    removeSelectedFacility,
    changeAcceptMode
}
