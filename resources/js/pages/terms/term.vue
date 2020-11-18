<template>
    <div class="container-fluid bg-light-gray m-0 p-0 pb-5 pt-5">
        <div class="term-logo-container container d-flex justify-content-center">
            <img :src="`${baseUrl}/asset/img/icon/logo.png`" alt="" style="width:200px;">
        </div>
        <div class="container m-0 p-0 mx-auto advice-to-customers mt-3 mb-3 box-block">
            <div class="px-5 pb-5 pt-2">
                <div class="d-flex justify-content-center align-items-center">
                    <h3 class="p-3 text-center">{{ $t('term').titleOfTerm }}</h3>
                </div>
                <div>
                    <p>{{ $t('term').contentOfTitle }}</p>
                </div>
                <h5 class="pt-4">{{ $t('term').title1 }}</h5>
                <p>{{ $t('term').content1 }}</p>
                <h5 class="pt-4">{{ $t('term').title2 }}</h5>
                <p> {{ $t('term').content2 }}</p>
                <h5 class="pt-4"> {{ $t('term').title3 }}</h5>
                <p>{{ $t('term').content3.content1 }}
                        <ul class="pl-4">
                            <li>{{ $t('term').content3.li1 }}</li>
                            <li>{{ $t('term').content3.li2 }}</li>
                            <li>{{ $t('term').content3.li3 }}</li>
                            <li>{{ $t('term').content3.li4 }}</li>
                        </ul>	
                    {{ $t('term').content3.content2 }}
                </p>
                <h5 class="pt-4"> {{ $t('term').title4 }}</h5>
                <p>{{ $t('term').content4 }} </p>
                <h5 class="pt-4">{{ $t('term').title5 }}</h5>
                <p>{{ $t('term').content5 }}</p>
                <h5 class="pt-4">{{ $t('term').title6 }}</h5>
                <p>{{ $t('term').content6 }}</p>
                <h5 class="pt-4">{{ $t('term').title7 }}</h5>
                <ul class="pl-4">
                    <li>{{ $t('term').content7.li1 }}</li>
                    <li>{{ $t('term').content7.li2 }}</li>
                    <li>{{ $t('term').content7.li3 }}</li>
                    <li>{{ $t('term').content7.li4 }}</li>
                    <li>{{ $t('term').content7.li5 }}</li>
                </ul>
                <h5 class="pt-4">{{ $t('term').title8 }}</h5>
                <p> {{ $t('term').content8 }}</p>
                <h5 class="pt-4">{{ $t('term').title9 }}</h5>
                <p> {{ $t('term').content9 }}</p>
                <h5 class="pt-4">{{ $t('term').title10 }}</h5>
                <p> {{ $t('term').content10 }}</p>
                <h5 class="pt-4">{{ $t('term').title11 }}</h5>
                <p>{{ $t('term').content11 }} </p>
                <h5 class="pt-4">{{ $t('term').title12 }}</h5>
                <p>{{ $t('term').content12 }} </p>
                <h5 class="pt-4">{{ $t('term').title13 }}</h5>
                <p>{{ $t('term').content13 }} </p>
                <h5 class="pt-4">{{ $t('term').title14 }}</h5>
                <p>{{ $t('term').content14 }} </p>
                <h5 class="pt-4">{{ $t('term').title15 }}</h5>
                <p>{{ $t('term').content15 }} </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').term }
    },
    data: () => ({
        baseUrl:window.base_url,

    }),
}
</script>