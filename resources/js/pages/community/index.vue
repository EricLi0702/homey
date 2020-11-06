<template>
    <div class="container-fluid bg-light-gray m-0 p-0">
        <!-- <div class="apt-img hv-40">
            <img :src="`${baseUrl}/asset/img/bg/room11.png`">
        </div> -->
        <div class="community-sub-menu container-fluid bg-white box-block">
            <div class="container d-flex justify-content-between p-0 py-3 ">
                <Input class="w-40"
                 search placeholder="Enter something..." />
                <div class="community-sub-menu-items">
                    <router-link :to="{ name: 'community.create' }" class="">
                        <!-- {{ $t('register') }} -->
                        <Button type="success" icon="md-add">{{ $t('community').New }}</Button>
                    </router-link>
                    <router-link :to="{ name: 'community.list' }" class="">
                        <!-- {{ $t('register') }} -->
                        <Button type="primary" icon="md-list">{{ $t('community').View }}</Button>
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
export default {
    middleware: 'auth',
    components:{
        Breadcrumb,
    },
    data(){
        return{
            baseUrl:window.base_url,
        }
    }
}
</script>