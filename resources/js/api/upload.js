import axios from 'axios'

function delUploadFile(file){
    return axios.delete('/api/fileUpload/file',file )
}


export{
    delUploadFile,
}
