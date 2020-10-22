import axios from 'axios'

// HTTP Request & Response 
const config = {
  baseUrl:'https://api.hnpwa.com/v0/'
};


//API functions 
function fetchNewsList () {
    return axios.get(`${config.baseUrl}news/1.json`)
}

function fetchAskList(){
    return axios.get(`${config.baseUrl}ask/1.json`)
}

function fetchJobsList(){
    return axios.get(`${config.baseUrl}jobs/1.json`)
}

function fetchUsers(){
    return axios.get('/api/users')
}

export{
    fetchNewsList,
    fetchAskList,
    fetchJobsList,
    fetchUsers,
}