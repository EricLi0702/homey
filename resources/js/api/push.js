import axios from 'axios'

function newPush(payload){
    return axios.post('/api/newPush',payload)
}
function removeNotificationFromNewGroup(payload){
    return axios.post('/api/removePushNotification',payload)
}
function removeSuggestionFromNewGroup(payload){
    return axios.post('/api/removePushSuggestion',payload)
}
function removeCommunityFromNewGroup(payload){
    return axios.post('/api/removePushCommunity',payload)
}

function getNewPush(){
    return axios.get('/api/newPush')
}

export{
    newPush,
    getNewPush,
    removeNotificationFromNewGroup,
    removeSuggestionFromNewGroup,
    removeCommunityFromNewGroup,
}