import axios from 'axios'

function getNotificationList(page){
   return axios.get(`/api/notification?page=${page}`)
}

function getDowngradNotificationList(page){
   return axios.get(`/api/notification/downgrade?page=${page}`)
}

function registerNotification(payload){
    return axios.post('/api/notification/create',payload)
}

function updateNotification(payload){
    return axios.put('/api/notification',payload)
}

function downgradeNotification(payload){
    return axios.put('/api/notification/down',payload)
}

function upgradeNotification(payload){
    return axios.put('/api/notification/up',payload)
}

function deleteNotification(payload){
    return axios.delete('/api/notification',{data: payload})
}

function getCurrentNotificationFromServer(currentId){
    return axios.get('/api/notification/current',{params: { id: currentId }});
}

function viewedCurrentNotification(currentId){
    let obj = {id : currentId}
    return axios.post('/api/notification/view',obj)
}
function getTop5Notification(currentId){
    return axios.get('/api/top5Notification',{params: {id:currentId}})
}

function getNotificationCnt(){
    return axios.get('/api/notificationCnt')
}

function getFirstItem(){
    return axios.get('/api/notification/first')
}
function getLastItem(){
    return axios.get('/api/notification/last')
}
function getPreviousItem(notificationId){
    return axios.get('/api/notification/previous', {params:{id:notificationId}})
}
function getNextItem(notificationId){
    return axios.get('/api/notification/next', {params:{id:notificationId}})
}

function getDraft(){
    return axios.get('/api/notification/draft');
}

export{
    getNotificationList,
    registerNotification,
    updateNotification,
    deleteNotification,
    getCurrentNotificationFromServer,
    viewedCurrentNotification,
    downgradeNotification,
    upgradeNotification,
    getDowngradNotificationList,
    getTop5Notification,
    getNotificationCnt,
    getFirstItem,
    getLastItem,
    getPreviousItem,
    getNextItem,
    getDraft,
}
