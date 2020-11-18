<template>
    <footer class="footer-section">
        <div class="container">
            <div class="footer-cta pt-5 pb-5">
                <div class="row d-flex p-0 m-0 ">
                    <div class="col-12 m-0 p-0 mb-3">
                        <h1 class="text-bold text-white">{{ $t('welcome').HomeyApt }}</h1>
                    </div>
                    <div class="col-xl-6 col-md-6 mb-30 p-0">
                        <div class="single-cta d-flex justify-content-start align-items-start ">
                            <Icon type="md-locate" color="#FF5E14" size="30"/>
                            <div class="cta-text">
                                <h4>{{ $t('welcome').FindUs }}</h4>
                                <span>{{ $t('welcome').AvenueAddress }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 mb-30 p-0 pl-md-2">
                        <div class="single-cta d-flex justify-content-start align-items-start">
                            <Icon type="ios-phone-portrait" color="#FF5E14" size="30" />
                            <div class="cta-text">
                                <h4>{{ $t('welcome').CallUs }}</h4>
                                <span>{{ $t('welcome').CellNum }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-content pt-1 pb-1">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 mb-50">
                        <div class="footer-widget">
                            <div class="footer-logo">
                                <a href="/">
                                    <img :src="`${baseUrl}/asset/img/icon/logo.png`" alt="">
                                </a>
                            </div>
                            <div class="footer-text">
                                <h3 class="text-gray">{{ $t('welcome').Support }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                        <div class="footer-widget">
                            <div class="single-cta d-flex justify-content-start align-items-center mb-2">
                                <Icon type="md-locate" color="#FF5E14" size="30"/>
                                <div class="cta-text">
                                    <h4>{{ $t('welcome').footerLocate }}</h4>
                                </div>
                            </div>
                            <div class="single-cta d-flex justify-content-start align-items-center mb-2">
                                <Icon type="ios-person" color="#FF5E14" size="30" />
                                <div class="cta-text">
                                    <h4>{{ $t('welcome').NName }}</h4>
                                </div>
                            </div>
                            <div class="single-cta d-flex justify-content-start align-items-center mb-2">
                                <Icon type="ios-mail-open" color="#FF5E14" size="30"/>
                                <div class="cta-text">
                                    <h4>{{ $t('welcome').HomeyCom }}</h4>
                                </div>
                            </div>
                            <div class="single-cta d-flex justify-content-start align-items-center mb-2">
                                <Icon type="ios-phone-portrait" color="#FF5E14" size="30" />
                                <div class="cta-text">
                                    <h4>+84 357 852 066</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-50 text-md-center">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <router-link :to="{ name: 'term' }">
                                    <h3>{{ $t('welcome').TermsUse }}</h3>
                                </router-link>
                                <router-link :to="{ name: 'privacy' }">
                                    <h3>{{ $t('welcome').PrivacyPolicy }}</h3>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 text-center align-items-center justify-content-center">
                        <div class="copyright-text">
                            <p>Copyright &copy; HOMEY Guide All Rights Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    
    data: () => ({
        baseUrl:window.base_url,

    }),
}
</script>