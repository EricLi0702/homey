<template>
    <div class="container-fluid bg-light-gray m-0 p-0 pb-5">
        <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
            <div class="p-3 py-5">
                <h2 class="p-3">Request Type</h2>
                <div class="col-6 mb-3 gray-input">
                    <Input placeholder="please enter title" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//import Api
import {} from '~/api/suggestion'

export default {
    middleware: 'auth',

    components: {
        
    },

    data(){
        return{
            
        }
    },

    methods:{
        async registerSuggestion(){
            this.emoStatus = false;
            console.log(this.createSuggestionData);
            if(this.createSuggestionData.title.trim() == ''){
                return this.error('Title is required')
            }
            if(this.createSuggestionData.desc.trim() == ''){
                return this.error('Description is required')
            }

            this.isSuggesting = true;
            await registerSuggestion(this.createSuggestionData)
            .then(res=>{
                // let newSuggestion = res.data.suggestion;
                // console.log(newSuggestion);
                // let parsed = JSON.parse(newSuggestion.upload_file);
                // console.log(parsed);
                this.createSuggestionData.title = '';
                this.createSuggestionData.desc = '';
                this.createSuggestionData.file.imgUrl = [];
                this.createSuggestionData.file.otherUrl = [];
                this.createSuggestionData.file.videoUrl = [];
                this.$router.push({path:'/suggestion/index'})
                
            })
            .catch(err=>{
                console.log(err);
            })
            this.isSuggesting = false
        },

        async saveToDraftSuggestion(){
            this.emoStatus = false;
            console.log(this.createSuggestionData);
            if(this.createSuggestionData.title.trim() == ''){
                return this.error('Title is required')
            }
            if(this.createSuggestionData.desc.trim() == ''){
                return this.error('Description is required')
            }
            this.createSuggestionData.isDraft = 1;
            this.isSavingDraft = true;
            await registerSuggestion(this.createSuggestionData)
            .then(res=>{
                this.createSuggestionData.title = '';
                this.createSuggestionData.desc = '';
                this.createSuggestionData.file.imgUrl = [];
                this.createSuggestionData.file.otherUrl = [];
                this.createSuggestionData.file.videoUrl = [];
                // this.$router.push({path:'/suggestion/index'})
                
            })
            .catch(err=>{
                console.log(err);
            })
            this.isSavingDraft = false
        },

        async deleteFile(type,fileName){
            let filePath = '';
            if(type == 'image'){
                filePath = fileName
            }else {
                filePath = fileName.imgUrl
            }

            let file = {fileName:filePath}

            await delUploadFile(file)
            .then(res=>{
                    if(type == 'image'){
                        this.createSuggestionData.file.imgUrl.pop(fileName)
                    }else if(type == 'other'){
                        this.createSuggestionData.file.otherUrl.pop(fileName)
                    }else if(type == 'video'){
                        this.createSuggestionData.file.videoUrl.pop(fileName)
                    }
                })
            .catch(err=>{
                console.log(err);
            })
            // if(res.status == 200){
            //     if(type == 'image'){
            //         this.createSuggestionData.file.imgUrl.pop(fileName)
            //     }else if(type == 'other'){
            //         this.createSuggestionData.file.otherUrl.pop(fileName)
            //     }else if(type == 'video'){
            //         this.createSuggestionData.file.videoUrl.pop(fileName)
            //     }
            // }else{
            //     this.swr();
            // }
        },

        //listen event from Upload
        upImgUrl(value) {
            this.createSuggestionData.file.imgUrl.push(value);
        },
        upFileUrl(value) {
            this.createSuggestionData.file.otherUrl.push(value);
        },
        upVideoUrl(value) {
            this.createSuggestionData.file.videoUrl.push(value);
        },

    }
}
</script>