import axios from 'axios'

function getReservationList(){
   return axios.get('/api/reservation')
}

function createReservation(payload){
    return axios.post('/api/reservation/create',payload)
}

function updateReservation(payload){
    return axios.put('/api/apartment',payload)
}

function delReservation(payload){
    return axios.delete('/api/apartment',payload)
}

export{
    getReservationList,
    createReservation,
    updateReservation,
    delReservation,
}
