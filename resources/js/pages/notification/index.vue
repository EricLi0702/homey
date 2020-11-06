<template>
    <div class="container-fluid bg-light-gray m-0 p-0">
        <!-- <div class="apt-img hv-40 noti-apt-img">
        </div> -->
        <div class="notification-sub-menu container-fluid bg-white box-block">
            <div class="container d-flex justify-content-between p-0 py-3 ">
                <Input class="w-40"
                 search :placeholder="$t('facility').EnterSomething" />
                <div class="notification-sub-menu-items">
                    <router-link v-if="currentUser.roleId == 2" :to="{ name: 'notification.register' }" class="">
                        <!-- {{ $t('register') }} -->
                        <Button type="success" icon="md-add">{{$t('community').New}}</Button>
                    </router-link>
                    <router-link v-if="currentUser.roleId == 2" :to="{ name: 'notification.downgradelist' }" class="">
                        <!-- {{ $t('register') }} -->
                        <Button type="warning" icon="md-trending-down">{{$t('notification').DownGraded}}</Button>
                    </router-link>
                    <router-link :to="{ name: 'notification.list' }" class="">
                        <!-- {{ $t('register') }} -->
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