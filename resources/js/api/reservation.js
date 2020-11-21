import axios from 'axios'

function getReservationList(){
   return axios.get('/api/reservation')
}

function createReservation(payload){
    return axios.post('/api/reservation/create',payload)
}

function allowReservation(payload){
    return axios.put('/api/reservation/allow',payload)
}

function denyReservation(payload){
    return axios.put('/api/reservation/deny',payload)
}

function delReservation(payload){
    return axios.delete('/api/reservation',{data: payload})
}

function getReservationCnt(){
    return axios.get('/api/reservatoinCnt')
}

export{
    getReservationList,
    createReservation,
    allowReservation,
    denyReservation,
    delReservation,
    getReservationCnt,
}
