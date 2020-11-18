import axios from 'axios'

function getCommunityList(page){
   return axios.get(`/api/community?page=${page}`)
}

function registerCommunity(payload){
    return axios.post('/api/community/create',payload)
}

function updateCommunity(payload){
    return axios.put('/api/community/update',payload)
}

function deleteCommunity(payload){
    return axios.put('/api/community/remove',payload)
}

function deleteComment(payload){
    return axios.put('/api/community/comment',payload)
}

function replyToComment(payload){
    return axios.post('/api/community/reply',payload)
}

function viewCurrentCommunity(currentId){
    let obj = {id : currentId}
    return axios.post('/api/community/view',obj)
}
function getCurrentCommunityFromServer(currentId){
    return axios.get('/api/community/current',{params: { id: currentId }});
}
// function getCommentsOfCurrentCommunity(page){
    
//     return axios.get(`/api/community/comment?page=${page}`)
// }
function getCommentsOfCurrentCommunity(page, currentId){
    // let obj = {id : currentId}
    return axios.get(`/api/community/comment?page=${page}`, {params: { id: currentId }})
}
function leaveCommentToCommunity(commentData, communityData){
    var obj = {};
    obj['commentData'] = commentData;
    obj['communityData'] = communityData;
    return axios.post('/api/community/comment', obj );
}

function getTop5Community(userId){
    return axios.get('/api/top5Community',{params:{id:userId}})
}

function getCommunityCnt(){
    return axios.get('/api/communityCnt');
}

function getFirstItem(){
    return axios.get('/api/community/first')
}
function getLastItem(){
    return axios.get('/api/community/last')
}
function getPreviousItem(notificationId){
    return axios.get('/api/community/previous', {params:{id:notificationId}})
}
function getNextItem(notificationId){
    return axios.get('/api/community/next', {params:{id:notificationId}})
}


export{
    getCommunityList,
    registerCommunity,
    updateCommunity,
    deleteCommunity,
    deleteComment,
    replyToComment,
    getCurrentCommunityFromServer,
    getCommentsOfCurrentCommunity,
    leaveCommentToCommunity,
    viewCurrentCommunity,
    getTop5Community,
    getCommunityCnt,
    getFirstItem,
    getLastItem,
    getPreviousItem,
    getNextItem,
}
