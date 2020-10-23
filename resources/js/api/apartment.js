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
    return axios.delete('/api/apartment',payload)
}

export{
    getAptLists,
    addApt,
    updateApt,
    delApt,
}
