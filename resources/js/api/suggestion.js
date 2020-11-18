import axios from 'axios'

function getSuggestionList(page){
   return axios.get(`/api/suggestion?page=${page}`)
}

function registerSuggestion(payload){
    return axios.post('/api/suggestion/create',payload)
}

function updateSuggestion(payload){
    return axios.put('/api/suggestion/update',payload)
}

function deleteSuggestion(payload){
    return axios.put('/api/suggestion/remove',payload)
}

function deleteComment(payload){
    return axios.put('/api/suggestion/comment',payload)
}

function heartToSuggestion(payload){
    return axios.post('/api/suggestion/heart',payload)
}
function likeToSuggestion(payload){
    return axios.post('/api/suggestion/like',payload)
}
function dislikeToSuggestion(payload){
    return axios.post('/api/suggestion/dislike',payload)
}

function unHeartToSuggestion(payload){
    return axios.post('/api/suggestion/unheart',payload)
}
function unLikeToSuggestion(payload){
    return axios.post('/api/suggestion/unlike',payload)
}
function unDislikeToSuggestion(payload){
    return axios.post('/api/suggestion/undislike',payload)
}
function viewCurrentSuggestion(currentId){
    let obj = {id : currentId}
    return axios.post('/api/suggestion/view',obj)
}
function getCurrentSuggestionFromServer(currentId){
    return axios.get('/api/suggestion/current',{params: { id: currentId }});
}
// function getCommentsOfCurrentSuggestion(page){
    
//     return axios.get(`/api/suggestion/comment?page=${page}`)
// }
function getCommentsOfCurrentSuggestion(page, currentId){
    // let obj = {id : currentId}
    return axios.get(`/api/suggestion/comment?page=${page}`, {params: { id: currentId }})
}
function leaveCommentToSuggestion(commentData, suggestionData){
    var obj = {};
    obj['commentData'] = commentData;
    obj['suggestionData'] = suggestionData;
    return axios.post('/api/suggestion/comment', obj );
}

function getTop5Suggestion(userId){
    return axios.get('/api/top5Suggestion',{params:{id:userId}});
}

function getSuggestionCnt(){
    return axios.get('/api/suggestionCnt');
}

function getFirstItem(){
    return axios.get('/api/suggestion/first')
}
function getLastItem(){
    return axios.get('/api/suggestion/last')
}
function getPreviousItem(notificationId){
    return axios.get('/api/suggestion/previous', {params:{id:notificationId}})
}
function getNextItem(notificationId){
    return axios.get('/api/suggestion/next', {params:{id:notificationId}})
}

export{
    getSuggestionList,
    registerSuggestion,
    updateSuggestion,
    deleteSuggestion,
    deleteComment,
    heartToSuggestion,
    likeToSuggestion,
    dislikeToSuggestion,
    unHeartToSuggestion,
    unLikeToSuggestion,
    unDislikeToSuggestion,
    getCurrentSuggestionFromServer,
    getCommentsOfCurrentSuggestion,
    leaveCommentToSuggestion,
    viewCurrentSuggestion,
    getTop5Suggestion,
    getSuggestionCnt,
    getFirstItem,
    getLastItem,
    getPreviousItem,
    getNextItem,
}
