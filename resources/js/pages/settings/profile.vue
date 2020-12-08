<template>
  <div class="container-fluid bg-light-gray m-0 p-0 pb-5">
    <div class="container m-0 p-0 mx-auto advice-to-customers mt-5 mb-3 box-block">
      <div class="p-3 py-5">
        <h2 class="p-3">{{$t('setting').Profile}}</h2>
        <div class="row m-0 p-0 d-grid justify-content-center align-items-center">
          <div class="profile-user-avatar position-relative">
            <img :src="`${baseUrl}${user.user_avatar}`" class="rounded-circle profile-photo profile-avatar " alt="">
            <div class="user-avatar-hover justify-content-center align-items-center">
              <Upload
                ref="imageUploads"
                :headers="{'x-csrf-token': token, 'X-Requested-Width' : 'XMLHttpRequest'}"
                :on-success="imageSuccess"
                :on-error="handleError"
                :format="['jpg','gif','png']"
                :max-size="2048"
                :show-upload-list="false"
                :on-format-error="handleFormatError"
                :on-exceeded-size="handleMaxSize"
                action="/api/fileUpload/image">
                  <Icon class="pr-2 noti-upload-icons profile-upload-avatar-icon" color="" size="45" type="md-cloud-upload" />
              </Upload>
            </div>
          </div>
          <Button class="mt-3 mb-5" type="success" icon="md-contact" @click="updateAvatar" :disabled="isUpdatingAvatar" :loading="isUpdatingAvatar">{{ $t('auth').update }}</Button>

        </div>
        <div class="row m-0 p-0">
          <div class="col-12 mb-3 gray-input">
            <Input @on-enter="updateUserName" v-model="user.name" class="customInput w-100" :placeholder="$t('placeholder').enterName"/>
          </div>
          <div class="col-12 text-left d-flex justify-content-start mt-3 position-relative">
            <Button type="primary" @click="updateUserName" :disabled="isLoading" :loading="isLoading">{{ $t('auth').update }}</Button>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'
import i18n from '~/plugins/i18n'
import {updateAvatarOfUser, updateNewUserName} from '~/api/auth'
export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('metaInfo').profile }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: ''
    }),
    newName:'',
    baseUrl:window.base_url,
    imgUrl:'',
    token:'',
    isUpdatingAvatar: false,
    isLoading: false,
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  created () {
    this.token = window.Laravel.csrfToken;
  },

  methods: {
    async update () {
      const { data } = await this.form.patch('/api/settings/profile')

      this.$store.dispatch('auth/updateUser', { user: data })
    },
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
        this.user.user_avatar = res;
        this.imgUrl = res;
    },
    async updateAvatar(){
      if(this.imgUrl == ''){
        return this.error(i18n.t('alert').avatar);
      }
      this.isUpdatingAvatar = true;
      await updateAvatarOfUser(this.imgUrl)
      .then(res=>{
        if(res.data.msg = 1){
          return this.success(i18n.t('alert').updateAvatarSuccessfully);
        }
        else{
          return this.error(i18n.t('alert').swr);
        }
      })
      .catch(err=>{
        console.log(err)
      })
      this.isUpdatingAvatar = false;
    },
    async updateUserName(){
      if(this.user.name.trim() == ''){
        return this.error(i18n.t('alert').name);
      }
      this.isLoading = true;
      let payload = {
        newName : this.user.name
      }
      updateNewUserName(payload)
      .then(res=>{
        if(res.data.msg == 1){
          this.success(i18n.t('alert').update);
          this.isLoading = false;
        }
      })
      .catch(err=>{
        this.isLoading = false;
        console.log(err.response);
      })
      this.isLoading = false
    },
  }
}
</script>
