<template>
    <footer class="footer-section">
        <div class="container">
            <div class="footer-cta pt-5 pb-5">
                <div class="row d-flex p-0 m-0 ">
                    <div class="col-12 m-0 p-0 mb-3">
                        <h1 class="text-bold text-white">Homey Apt</h1>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-30 p-0">
                        <div class="single-cta d-flex justify-content-start align-items-start ">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="cta-text">
                                <h4>Find us</h4>
                                <span>1010 Avenue, sw 54321, chandigarh</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-30 p-0 pl-md-2">
                        <div class="single-cta d-flex justify-content-start align-items-start">
                            <i class="fas fa-phone"></i>
                            <div class="cta-text">
                                <h4>Call us</h4>
                                <span>15140043021</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-30 p-0 pl-md-3">
                        <div class="single-cta d-flex justify-content-start align-items-start">
                            <i class="far fa-envelope-open"></i>
                            <div class="cta-text">
                                <h4>Mail us</h4>
                                <span>sammie123456@homey.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-content pt-5 pb-5">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 mb-50">
                        <div class="footer-widget">
                            <div class="footer-logo">
                                <a href="/">
                                    <img :src="`${baseUrl}/asset/img/icon/logo.png`" alt="">
                                </a>
                            </div>
                            <div class="footer-text">
                                <h3 class="text-gray">We support a happy life.</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                        <div class="footer-widget">
                            <div class="single-cta d-flex justify-content-start align-items-center ">
                                <Icon type="md-locate" color="#FF5E14" size="30"/>
                                <div class="cta-text">
                                    <h4>1010 Avenue, sw 54321, chandigarh</h4>
                                </div>
                            </div>
                            <div class="single-cta d-flex justify-content-start align-items-center ">
                                <Icon type="ios-person" color="#FF5E14" size="30" />
                                <div class="cta-text">
                                    <h4>Sammie</h4>
                                </div>
                            </div>
                            <div class="single-cta d-flex justify-content-start align-items-center ">
                                <Icon type="ios-mail-open" color="#FF5E14" size="30"/>
                                <div class="cta-text">
                                    <h4>Sammie@homey.com</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <a href="#">
                                    <h3>Terms of Use</h3>
                                </a>
                                <a href="#">
                                    <h3>Privacy Policy</h3>
                                </a>
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
                            <p>Copyright &copy; 2020, All Right Reserved <a href="#">MangoJam</a></p>
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