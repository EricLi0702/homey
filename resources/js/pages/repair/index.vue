<template>
    <div class="container-fluid bg-light-gray m-0 p-0 bg-wallpaper">
        <div class="suggestion-sub-menu container-fluid bg-white box-block">
            <div class="container d-flex justify-content-between p-0 py-3 row m-0 mx-auto">
                <Input class="col-12 col-md-6 p-0"
                 search :placeholder="$t('placeholder').enterSearchWord" />
                <div class="suggestion-sub-menu-items col-12 col-md-6 p-0 text-right">
                    <router-link v-if="currentUser.roleId !== 2 && currentUser.roleId !== 7 && currentUser.roleId !== 1" :to="{ path: '/repair/create' }" class="">
                        <Button type="success" icon="md-add">{{$t('community').New}}</Button>
                    </router-link>
                    <router-link v-if="currentUser.roleId == 2 || currentUser.roleId == 7" :to="{ path: '/repair/type' }" class="">
                        <Button type="warning" icon="logo-buffer">{{$t('repair').repairType}}</Button>
                    </router-link>
                    <router-link :to="{ path: '/repair/index' }" class="">
                        <Button type="primary" icon="md-list">{{$t('community').View}}</Button>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="container p-0 mb-3">
            <Breadcrumb />
        </div>
        <transition name="fade" mode="out-in">
        <router-view></router-view>
        </transition>
    </div>
</template>

<script>
import Breadcrumb from '~/components/Breadcrumb'
import { mapGetters } from 'vuex'
export default {
    middleware: 'auth',
    components:{
        Breadcrumb,
    },
    computed:{ 
        ...mapGetters({
            currentUser: 'auth/user'
        }),
    },
    data(){
        return{
            baseUrl:window.base_url,
        }
    }
}
</script>