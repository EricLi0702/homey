<template>
    <div class="d-flex">
        <Upload
            ref="imageUploads"
            :headers="{'x-csrf-token': token, 'X-Requested-Width' : 'XMLHttpRequest'}"
            :on-success="imageSuccess"
            :on-error="handleError"
            :format="['jpg','gif','png', 'jfif', 'pjpeg', 'jpeg', 'pjp']"
            :max-size="2048"
            :show-upload-list="false"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            accept="image/png, image/jpeg"
            action="/api/fileUpload/image">
                <Icon class="pr-2 noti-upload-icons" size="25" type="ios-image" />
        </Upload>
        <Upload
            ref="otherUploads"
            :headers="{'x-csrf-token': token, 'X-Requested-Width' : 'XMLHttpRequest'}"
            :on-success="otherSuccess"
            :on-error="handleError"
            :format="['doc','docx','zip','pdf','xls','xlsx','rp','mp3','rp','ppt','pptx','pptm','apk','rar']"
            :max-size="524288"
            :show-upload-list="false"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            accept=".doc, .docx, .zip, .pdf, .xls, .xlsx, .rp, .mp3, .rp, .ppt, .pptx, .pptm, .apk, .rar"
            action="/api/fileUpload/other">
                <Icon class="pr-2 noti-upload-icons" size="25" type="ios-folder" />
        </Upload>
        <Upload
            ref="videoUploads"
            :headers="{'x-csrf-token': token, 'X-Requested-Width' : 'XMLHttpRequest'}"
            :on-success="videoSuccess"
            :on-error="handleError"
            :format="['mp4']"
            :max-size="524288"
            :show-upload-list="false"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            accept="video/mp4"
            action="/api/fileUpload/video">
                <Icon class="pr-2 noti-upload-icons" size="25" type="ios-film" />
        </Upload>

    </div>
</template>

<script>
export default {
    data(){
        return{
            token:'',
        }
    },
    created(){
        this.token = window.Laravel.csrfToken
    },
    methods:{
        handleError (res, file) {
            this.$Message.warning(`${file.errors.file.length ? file.errors.file[0] : '出问题了！'}`)
        },
        handleFormatError (file) {
            this.$Message.warning('Format of ' + file.name + ' is not correct');
        },
        handleMaxSize (file) {
            this.$Message.warning('Size of' + file.name + ' could not over than 2M');
        },
        imageSuccess (res, file) {
            res = `/uploads/image/${res}`
            this.$emit('upImgUrl',res)
        },
        otherSuccess (res, file) {
            let url = `/uploads/other/${res.fileName}`;
            this.$set(res,'imgUrl',url)
            this.$emit('upFileUrl',res)
        },
        videoSuccess(res,file){
            let url = `/uploads/video/${res.fileName}`
            this.$set(res,'imgUrl',url)
            this.$emit('upVideoUrl',res)
        },
    }
}
</script>