<template>
    <div class="container-fluid bg-light-gray m-0 p-0 pb-5 pt-5">
        <div class="term-logo-container container d-flex justify-content-center">
            <img :src="`${baseUrl}/asset/img/icon/logo.png`" alt="" style="width:200px;">
        </div>
        <div class="container m-0 p-0 mx-auto advice-to-customers mt-3 mb-3 box-block">
            <div class="px-5 pb-5 pt-2">
                <div class="d-flex justify-content-center align-items-center">
                    <h3 class="p-3 text-center">{{ $t('privacy').titleOfPrivacy }}</h3>
                </div>
                <h5 class="pt-4">1. {{ $t('privacy').title1 }}</h5>
                <p>1.1 {{ $t('privacy').content1_1 }}</p>
                <p>1.2 {{ $t('privacy').content1_2 }}</p>
                <h5 class="pt-4">{{ $t('privacy').title2 }}</h5>
                <p>2.1 {{ $t('privacy').content2_1 }}</p>
                <p>2.2 {{ $t('privacy').content2_2 }}
                    <ul class="pl-4">
                        <li>a.{{ $t('privacy').content2_lia }}</li>
                        <li>b.{{ $t('privacy').content2_lib }}</li>
                        <li>c.{{ $t('privacy').content2_lic }}</li>
                        <li>d.{{ $t('privacy').content2_lid }}</li>
                        <li>e.{{ $t('privacy').content2_lie }}</li>
                        <li>f.{{ $t('privacy').content2_lif }}</li>
                        <li>g.{{ $t('privacy').content2_lig }}</li>
                        <li>h.{{ $t('privacy').content2_lih }}</li>
                    </ul>
                    {{ $t('privacy').content2__ }}
                </p>
                <p>2.3 {{ $t('privacy').content2_3 }}</p>
                <p>2.4 {{ $t('privacy').content2_4 }}</p>
                <p>2.5 {{ $t('privacy').content2_5 }}
                    <ul class="pl-4">
                        <li>{{ $t('privacy').content2_5_name }}</li>
                        <li>{{ $t('privacy').content2_5_phone }}</li>
                        <li>{{ $t('privacy').content2_5_email }}</li>
                        <li>{{ $t('privacy').content2_5_address }}</li>
                        <li>{{ $t('privacy').content2_5__ }}</li>
                    </ul>
                    {{ $t('privacy').content2_5___ }}
                </p>
                <h5 class="pt-4">3. {{ $t('privacy').title3 }}</h5>
                <p>{{ $t('privacy').content3}}</p>
                <h5 class="pt-4">4. {{ $t('privacy').title4 }}</h5>
                <p>{{ $t('privacy').content4 }} </p>
                <h5 class="pt-4">5. {{ $t('privacy').title5 }}</h5>
                <p>5.1 {{ $t('privacy').content5_1 }}</p>
                <p>5.2 {{ $t('privacy').content5_2 }}</p>
                <h5 class="pt-4">6. {{ $t('privacy').title6 }}</h5>
                <p>{{ $t('privacy').content6 }}</p>
                <h5 class="pt-4">7. {{ $t('privacy').title7 }}</h5>
                <p>{{ $t('privacy').content7 }}</p>
                <h5 class="pt-4">8. {{ $t('privacy').title8 }}</h5>
                <p> {{ $t('privacy').content8 }}</p>
                <h5 class="pt-4">9. {{ $t('privacy').title9 }}</h5>
                <p>9.1 {{ $t('privacy').content9_1 }}
                    <ul class="pl-4">
                        <li>a. {{ $t('privacy').content9_1_a }}</li>
                        <li>b. {{ $t('privacy').content9_1_b }}</li>
                        <li>c. {{ $t('privacy').content9_1_c }}</li>
                        <li>d. {{ $t('privacy').content9_1_d }}</li>
                        <li>e. {{ $t('privacy').content9_1_e }}</li>
                        <li>f. {{ $t('privacy').content9_1_f }}</li>
                        <li>g. {{ $t('privacy').content9_1_g }}</li>
                        <li>h. {{ $t('privacy').content9_1_h }}</li>
                        <li>i. {{ $t('privacy').content9_1_i }}</li>
                        <li>j. {{ $t('privacy').content9_1_j }}</li>
                        <li>k. {{ $t('privacy').content9_1_k }}</li>
                        <li>l. {{ $t('privacy').content9_1_l }}</li>
                        <li>m. {{ $t('privacy').content9_1_m }}</li>
                        <li>n. {{ $t('privacy').content9_1_n }}</li>
                        <li>o. {{ $t('privacy').content9_1_o }}</li>
                        <li>p. {{ $t('privacy').content9_1_p }}</li>
                        <li>q. {{ $t('privacy').content9_1_q }}</li>
                        <li>r. {{ $t('privacy').content9_1_r }}</li>
                        <li>s. {{ $t('privacy').content9_1_s }}</li>
                        <li>t. {{ $t('privacy').content9_1_t }}</li>
                        <li>u. {{ $t('privacy').content9_1_u }}</li>
                        <li>v. {{ $t('privacy').content9_1_v }}</li>
                    </ul>
                    9.2 {{ $t('privacy').content9_2 }}
                </p>
                <h5 class="pt-4">10. {{ $t('privacy').title10 }}</h5>
                <p> {{ $t('privacy').content10 }}</p>
                <h5 class="pt-4">11. {{ $t('privacy').title11 }}</h5>
                <p>{{ $t('privacy').content11 }} </p>
                <h5 class="pt-4">12. {{ $t('privacy').title12 }}</h5>
                <p>12.1 {{ $t('privacy').content12_1 }} 
                    <ul class="pl-4">
                        <li>a. {{ $t('privacy').content12_1_a }}</li>
                        <li>b. {{ $t('privacy').content12_1_b }}</li>
                        <li>c. {{ $t('privacy').content12_1_c }}</li>
                        <li>d. {{ $t('privacy').content12_1_d }}</li>
                    </ul>
                </p>
                <p>12.2 {{ $t('privacy').content12_2 }} </p>
                <p>12.3 {{ $t('privacy').content12_3 }} </p>
                <p>12.4 {{ $t('privacy').content12_4 }} </p>
                <h5 class="pt-4">13. {{ $t('privacy').title13 }}</h5>
                <p>{{ $t('privacy').content13 }} </p>
                <h5 class="pt-4">14. {{ $t('privacy').title14 }}</h5>
                <p>14.1 {{ $t('privacy').content14_1 }} </p>
                <p>14.2 {{ $t('privacy').content14_2 }} </p>
                <h5 class="pt-4">15. {{ $t('privacy').title15 }}</h5>
                <p>15.1 {{ $t('privacy').content15_1 }} </p>
                <p>15.2 {{ $t('privacy').content15_2 }} </p>
                <h5 class="pt-4">16. {{ $t('privacy').title16 }}</h5>
                <p>{{ $t('privacy').content16 }} </p>
                <h5 class="pt-4">17. {{ $t('privacy').title17 }}</h5>
                <p>17.1 {{ $t('privacy').content17_1 }} 
                    <ul class="pl-4">
                        <li>a. {{ $t('privacy').content17_1_a }}</li>
                        <li>b. {{ $t('privacy').content17_1_b }}</li>
                        <li>c. {{ $t('privacy').content17_1_c }}</li>
                        <li>d. {{ $t('privacy').content17_1_d }}</li>
                    </ul>
                </p>
                <p>17.2 {{ $t('privacy').content17_2 }} 
                    <ul class="pl-4">
                        <li>a. {{ $t('privacy').content17_2_a }}</li>
                        <li>b. {{ $t('privacy').content17_2_b }}</li>
                        <li>c. {{ $t('privacy').content17_2_c }}
                            <ul class="pl-4">
                                <li>i. {{ $t('privacy').content17_2_c_i }}</li>
                                <li>ii. {{ $t('privacy').content17_2_c_ii }}</li>
                            </ul>
                        </li>
                        <li>d. {{ $t('privacy').content17_2_d }}</li>
                        <li>e. {{ $t('privacy').content17_2_e }}</li>
                        <li>f. {{ $t('privacy').content17_2_f }}</li>
                    </ul>
                </p>
                <h5 class="pt-4">18. {{ $t('privacy').title18 }}</h5>
                <p>a. {{ $t('privacy').content18_a }} </p>
                <p>b. {{ $t('privacy').content18_b }} </p>
                <p>c. {{ $t('privacy').content18_c }} </p>
                <p>{{ $t('privacy').content18__ }} </p>
                <h5 class="pt-4">19. {{ $t('privacy').title19 }}</h5>
                <p>{{ $t('privacy').content19 }} </p>
                <h5 class="pt-4">20. {{ $t('privacy').title20 }}</h5>
                <p>{{ $t('privacy').content20 }} </p>
                <p>{{ $t('privacy').content20_last }} </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    metaInfo () {
        return { title: this.$t('metaInfo').privacy }
    },
    data: () => ({
        baseUrl:window.base_url,

    }),
}
</script>