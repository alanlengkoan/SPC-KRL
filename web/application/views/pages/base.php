<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <title>Selamat Datang | <?= $title ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Selamat Datang" />
    <meta name="keywords" content="Selamat Datang" />
    <meta name="author" content="Selamat Datang" />

    <!-- begin:: icon -->
    <link rel="apple-touch-icon" href="<?= assets_url() ?>admin/images/icon/apple-touch-icon.png" sizes="180x180" />
    <link rel="icon" href="<?= assets_url() ?>admin/images/icon/favicon-32x32.png" type="image/x-icon" sizes="32x32" />
    <link rel="icon" href="<?= assets_url() ?>admin/images/icon/favicon-16x16.png" type="image/x-icon" sizes="16x16" />
    <link rel="icon" href="<?= assets_url() ?>admin/images/icon/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?= assets_url() ?>admin/images/icon/favicon.ico" type="image/x-icon">
    <!-- end:: icon -->

    <!-- begin:: css global -->
    <link rel="stylesheet" href="<?= assets_url() ?>page/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= assets_url() ?>page/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= assets_url() ?>page/css/linearicons.css">
    <link rel="stylesheet" href="<?= assets_url() ?>page/css/magnific-popup.css">
    <link rel="stylesheet" href="<?= assets_url() ?>page/css/animate.css">
    <link rel="stylesheet" href="<?= assets_url() ?>page/css/normalize.css">
    <link rel="stylesheet" href="<?= assets_url() ?>page/css/style.css">
    <link rel="stylesheet" href="<?= assets_url() ?>page/css/responsive.css">
    <!-- end:: css global -->

    <script src="<?= assets_url() ?>page/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body data-spy="scroll" data-target=".mainmenu-area">

    <div class="preloader">
        <span><i class="lnr lnr-sun"></i></span>
    </div>

    <nav class="mainmenu-area" data-spy="affix" data-offset-top="200">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primary_menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="<?= assets_url() ?>page/images/logo.png" alt="Logo"></a>
            </div>
            <div class="collapse navbar-collapse" id="primary_menu">
                <ul class="nav navbar-nav mainmenu">
                    <li class="active">
                        <a href="#home_page">Home</a>
                    </li>
                    <li>
                        <a href="#about_page">About</a>
                    </li>
                    <li>
                        <a href="#features_page">Features</a>
                    </li>
                    <li>
                        <a href="#gallery_page">Gallery</a>
                    </li>
                    <li>
                        <a href="<?= login_url() ?>">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="home-area overlay" id="home_page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 hidden-sm col-md-5">
                    <figure class="mobile-image wow fadeInUp" data-wow-delay="0.2s">
                        <img src="<?= assets_url() ?>page/images/phone/header-mobile.png" alt>
                    </figure>
                </div>
                <div class="col-xs-12 col-md-7">
                    <div class="space-80 hidden-xs"></div>
                    <h1 class="wow fadeInUp" data-wow-delay="0.4s">Selamat Datang di Aplikasi Seaweed Detected App (SDA)</h1>
                    <div class="space-20"></div>
                    <a href="<?= assets_url() ?>download/sda.apk" class="bttn-white wow fadeInUp" data-wow-delay="0.8s"><i class="lnr lnr-download"></i>Download App</a>
                </div>
            </div>
        </div>
    </header>

    <!-- begin:: content -->
    <?php $this->load->view($content); ?>
    <!-- end:: content -->

    <div class="subscribe-area overlay section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                    <div class="subscribe-form text-center">
                        <h3 class="blue-color">Subscribe for More Features</h3>
                        <div class="space-20"></div>
                        <form id="mc-form">
                            <input type="email" class="control" placeholder="Enter your email" required="required" id="mc-email">
                            <button class="bttn-white active" type="submit"><span class="lnr lnr-location"></span> Subscribe</button>
                            <label class="mt10" for="mc-email"></label>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer-area" id="contact_page">
        <div class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="page-title text-center">
                            <h5 class="title">Contact US</h5>
                            <h3 class="dark-color">Find Us By Bellow Details</h3>
                            <div class="space-60"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="footer-box">
                            <div class="box-icon">
                                <span class="lnr lnr-map-marker"></span>
                            </div>
                            <p>8-54 Paya Lebar Square <br /> 60 Paya Lebar Roa SG, Singapore</p>
                        </div>
                        <div class="space-30 hidden visible-xs"></div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="footer-box">
                            <div class="box-icon">
                                <span class="lnr lnr-phone-handset"></span>
                            </div>
                            <p>+65 93901336 <br /> +65 93901337</p>
                        </div>
                        <div class="space-30 hidden visible-xs"></div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="footer-box">
                            <div class="box-icon">
                                <span class="lnr lnr-envelope"></span>
                            </div>
                            <p><a href="https://preview.colorlib.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="b2cbddc7c0dfd3dbdef2d5dfd3dbde9cd1dddf">[email&#160;protected]</a> <br /> <a href="https://preview.colorlib.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="482a292b233821382d3a662b2725082f25292124662b2725">[email&#160;protected]</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-5">

                        <span>&copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>. Developed with <i class="lnr lnr-heart"></i> by <a href="https://alanlengkoan.netlify.app/">alanlengkoan</a>
                        </span>

                        <div class="space-30 hidden visible-xs"></div>
                    </div>
                    <div class="col-xs-12 col-md-7">
                        <div class="footer-menu">
                            <ul>
                                <li><a href="#">About</a></li>
                                <li><a href="#">Services</a></li>
                                <li><a href="#">Features</a></li>
                                <li><a href="#">Pricing</a></li>
                                <li><a href="#">Testimonial</a></li>
                                <li><a href="#">Contacts</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </footer>

    <!-- begin:: js global -->
    <script src="<?= assets_url() ?>page/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="<?= assets_url() ?>page/js/vendor/jquery-ui.js"></script>
    <script src="<?= assets_url() ?>page/js/vendor/bootstrap.min.js"></script>
    <script src="<?= assets_url() ?>page/js/owl.carousel.min.js"></script>
    <script src="<?= assets_url() ?>page/js/contact-form.js"></script>
    <script src="<?= assets_url() ?>page/js/ajaxchimp.js"></script>
    <script src="<?= assets_url() ?>page/js/scrollUp.min.js"></script>
    <script src="<?= assets_url() ?>page/js/magnific-popup.min.js"></script>
    <script src="<?= assets_url() ?>page/js/wow.min.js"></script>
    <script src="<?= assets_url() ?>page/js/main.js"></script>
    <!-- end:: js global -->
</body>

</html>