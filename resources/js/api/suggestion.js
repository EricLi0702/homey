import axios from 'axios'

function getSuggestionList(page){
   return axios.get(`/api/suggestion?page=${page}`)
}

function registerSuggestion(payload){
    return axios.post('/api/suggestion/create',payload)
}

function updateSuggestion(payload){
    return axios.put('/api/apartment',payload)
}

function delSuggestion(payload){
    return axios.delete('/api/apartment',payload)
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


export{
    getSuggestionList,
    registerSuggestion,
    updateSuggestion,
    delSuggestion,
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
}
