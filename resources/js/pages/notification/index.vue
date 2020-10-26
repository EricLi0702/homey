<template>
    <div class="container-fluid bg-light-gray m-0 p-0">
        <div class="apt-img hv-40">
            <img :src="`${baseUrl}/asset/img/bg/room11.png`">
        </div>
        <div class="notification-sub-menu container-fluid bg-white box-block">
            <div class="container d-flex justify-content-between p-0 py-3 ">
                <Input class="w-40"
                 search placeholder="Enter something..." />
                <div class="notification-sub-menu-items">
                    <router-link :to="{ name: 'notification.register' }" class="">
                        <!-- {{ $t('register') }} -->
                        <Button>New Notification</Button>
                    </router-link>
                    <router-link :to="{ name: 'notification.list' }" class="">
                        <!-- {{ $t('register') }} -->
                        <Button>View Notification</Button>
                    </router-link>
                </div>
            </div>
        </div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    middleware: 'auth',
    data(){
        return{
            baseUrl:window.base_url,
        }
    }
}
</script>