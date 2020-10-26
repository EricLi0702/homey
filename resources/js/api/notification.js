import axios from 'axios'

function getNotificationList(page){
   return axios.get(`/api/notification?page=${page}`)
}

function registerNotification(payload){
    return axios.post('/api/notification/create',payload)
}

function updateNotification(payload){
    return axios.put('/api/apartment',payload)
}

function delNotification(payload){
    return axios.delete('/api/apartment',payload)
}

export{
    getNotificationList,
    registerNotification,
    updateNotification,
    delNotification,
}
