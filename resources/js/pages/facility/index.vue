<template>
    <div class="container-fluid bg-light-gray m-0 p-0 bg-wallpaper">
        <div class="suggestion-sub-menu container-fluid bg-white box-block">
            <div class="container d-flex justify-content-between p-0 py-3 row m-0 mx-auto">
                <Input class="col-12 col-md-6 p-0"
                 search :placeholder="$t('placeholder').enterSearchWord" />
                <div class="suggestion-sub-menu-items col-12 col-md-6 p-0 text-right">
                    <router-link :to="{ path: '/facility/reservation' }" class="">
                        <Button type="warning" icon="md-checkbox-outline">{{$t('publicFacility').reservation}}</Button>
                    </router-link>
                    <router-link v-if="currentUser.role.roleName == 'SuperManager'" :to="{ path: '/facility/create' }" class="">
                        <Button type="success" icon="md-add">{{$t('publicFacility').newFacility}}</Button>
                    </router-link>
                    <router-link :to="{ path: '/facility/index' }" class="">
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
    computed: mapGetters({
        currentUser: 'auth/user'
    }),
    components:{
        Breadcrumb,
    },
    data(){

        return{
            baseUrl:window.base_url,
        }
    },
    methods:{
        viewList(){
            this.isViewList = true;
        }
    }
}
</script>