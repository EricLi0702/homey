import axios from 'axios'

function postValidation(payload){
    return axios.post('/api/verify',payload)
}

function verifyingCodeFromEmail(payload){
    return axios.post('/api/verifycode', payload)
}

function setupPassword(password, userData){
    let obj = {}
    obj['password'] = password;
    obj['userData'] = userData;
    return axios.post('/api/setpassword', obj)
}

function updateAvatarOfUser(imgUrl){
    let imageUrl = { imgPath : imgUrl}
    return axios.post('/api/settings/avatar', imageUrl)
}

function verifyUserEmailResetPass(payload){
    return axios.post('/api/password/email', payload)
}

function verifyingCodeFromEmailResetPass(payload){
    return axios.post('/api/password/verifycode', payload)
}

function setupPasswordResetPass(password, userEmail){
    let obj = {}
    obj['password'] = password;
    obj['userEmail'] = userEmail;
    return axios.post('/api/password/setpassword', obj)
}


export{
    postValidation,
    verifyingCodeFromEmail,
    setupPassword,
    updateAvatarOfUser,
    verifyUserEmailResetPass,
    verifyingCodeFromEmailResetPass,
    setupPasswordResetPass,
}
