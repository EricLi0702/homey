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

function delFacility(payload){
    return axios.delete('/api/apartment',payload)
}

export{
    getFacilityList,
    registerFacility,
    updateFacility,
    delFacility,
}
