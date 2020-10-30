<template>
    <div class="container-fluid bg-light-gray m-0 p-0 bg-wallpaper">
        <!-- <div class="apt-img hv-40 service-apt-img">
        </div> -->
        <div class="suggestion-sub-menu container-fluid bg-white box-block">
            <div class="container d-flex justify-content-between p-0 py-3 ">
                <Input class="w-40"
                 search placeholder="Enter something..." />
                <div class="suggestion-sub-menu-items">
                    <router-link :to="{ path: '/repair/create' }" class="">
                        <!-- {{ $t('register') }} -->
                        <Button type="success" icon="md-add">New</Button>
                    </router-link>
                    <router-link :to="{ path: '/repair/type' }" class="">
                        <!-- {{ $t('register') }} -->
                        <Button type="warning" icon="logo-buffer">Type</Button>
                    </router-link>
                    <router-link :to="{ path: '/repair/index' }" class="">
                        <!-- {{ $t('register') }} -->
                        <Button type="primary" icon="md-list">View</Button>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="container p-0 mb-3">
            <Breadcrumb />
        </div>
        <router-view></router-view>
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