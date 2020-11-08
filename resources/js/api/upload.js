import axios from 'axios'

function delUploadFile(filePath){
        return axios.delete('/api/fileUpload/file', { data: { fileName: filePath } } )
}


export{
    delUploadFile,
}
