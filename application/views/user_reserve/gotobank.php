<!DOCTYPE html>
<html lang="en">
<head>

    <!-- SITE TITTLE -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>پی سالن-رزرو تایم</title>

    <!-- FAVICON -->
    <link href="<?= assets_url() ?>app-assets/front2/img/favicon.png" rel="shortcut icon">
    <!-- PLUGINS CSS STYLE -->
    <!-- <link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet"> -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= assets_url() ?>app-assets/front2/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= assets_url() ?>app-assets/front2/plugins/bootstrap/css/bootstrap-slider.css">
    <!-- Font Awesome -->
    <link href="<?= assets_url() ?>app-assets/front2/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Owl Carousel -->
    <link href="<?= assets_url() ?>app-assets/front2/plugins/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="<?= assets_url() ?>app-assets/front2/plugins/slick-carousel/slick/slick-theme.css" rel="stylesheet">
    <!-- Fancy Box -->
    <link href="<?= assets_url() ?>app-assets/front2/plugins/fancybox/jquery.fancybox.pack.css" rel="stylesheet">
    <link href="<?= assets_url() ?>app-assets/front2/plugins/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <!-- CUSTOM CSS -->
    <link href="<?= assets_url() ?>app-assets/front2/css/style.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel='stylesheet'  href='https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css' type='text/css' />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>

        .boxed label {
            display: inline-block;
            width: 200px;
            padding: 10px;
            border: solid 2px #c1e2b3;
            transition: all 0.3s;

        }

        .boxed input[type="radio"] {
            display: none;
        }

        .boxed input[type="radio"]:checked + label {
            border: solid 2px green;
        }
    </style>
</head>

<body class="body-wrapper">


<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-light navigation">
                    <a class="navbar-brand" href="index.html">
                        <img src="images/logo.png" alt="">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto main-nav " dir="rtl">
                            <li class="nav-item active">
                                <a class="nav-link" href="http://pibeautysalon.com/">پی سالن</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="http://pibeautysalon.com/">خدمات</a>
                            </li>
                            <!-- <li class="nav-item dropdown dropdown-slide">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pages <span><i class="fa fa-angle-down"></i></span>
                                </a>

                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="about-us.html">About Us</a>
                                    <a class="dropdown-item" href="contact-us.html">Contact Us</a>
                                    <a class="dropdown-item" href="user-profile.html">User Profile</a>
                                    <a class="dropdown-item" href="404.html">404 Page</a>
                                    <a class="dropdown-item" href="package.html">Package</a>
                                    <a class="dropdown-item" href="single.html">Single Page</a>
                                    <a class="dropdown-item" href="store.html">Store Single</a>
                                    <a class="dropdown-item" href="single-blog.html">Single Post</a>
                                    <a class="dropdown-item" href="blog.html">Blog</a>

                                </div>
                            </li>-->

                        </ul>
                        <ul class="navbar-nav ml-auto mt-10">
                            <!--  <li class="nav-item">
                                   <a class="nav-link login-button" href="login.html">Login</a>
                               </li>
                               <li class="nav-item">
                                   <a class="nav-link text-white add-button" href="ad-listing.html"><i class="fa fa-plus-circle"></i> Add Listing</a>
                               </li>-->
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>

<!--===============================
=            Hero Area            =
================================-->



<section class="hero-area bg-1 text-center overly">
    <!-- Container Start -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Header Contetnt -->
                <div class="content-block">
                    <h1>پی سالن </h1>
                    <p>نمایش زیبایی درون و بیرون ِ زنان پیشروی جامعه در برند پی</p>
                </div>
                <!-- Advance Search -->
                <div class="advance-search">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 col-md-12 align-content-center">
                                <form action="<?php echo base_url().'user_reserve/gotobank'?>" method="post" >
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                    <input type="hidden" name="mobile" value="<?php echo $mobile; ?>">
                                    <input type="hidden" name="name" value="<?php echo $name; ?>">
                                    <input type="hidden" name="referrerCode" value="<?php echo $referrerCode; ?>">
                                    <input type="hidden" name="data" value="<?php echo htmlspecialchars($data); ?>">
                                    <p>پیش پرداخت آنلاین</p>
                                    <p>برای رزرو قطعی هر سرویس 50 هزار تومان واریز نمایید</p>
                                    <div class="form-row" dir="rtl" align="center">
                                        <div class="form-group col-md-12 boxed">

                                            <?php
                                            $price=0;
                                            foreach (json_decode($data) as $item)
                                            {
                                                $price+=50000;
                                            }
                                            echo "مبلغ پیش پرداخت ".number_format($price)." تومان ";
                                            ?>
                                       </div>



                                        <div class="form-group col-md-12 align-self-center" align="center">
                                            <button type="submit" class="btn btn-primary" style="background: #c29e76;border:solid 1px #c29e76;">پرداخت</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Container End -->
</section>

<!--===================================
=            Client Slider            =
====================================-->

<!--==========================================
=            All Category Section            =
===========================================-->

<section class=" section">
    <!-- Container Start -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Section title -->
                <div class="section-title">
                    <h2>خدمات پی سالن</h2>
                </div>
                <div class="row">
                    <!-- Category list -->
                    <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                        <div class="category-block">
                            <div class="header">
                                <i class="fa fa-laptop icon-bg-1"></i>
                                <h4>مانیکور</h4>
                            </div>

                        </div>
                    </div> <!-- /Category List -->
                    <!-- Category list -->
                    <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                        <div class="category-block">
                            <div class="header">
                                <i class="fa fa-apple icon-bg-2"></i>
                                <h4>پدیکور</h4>
                            </div>
                        </div>
                    </div> <!-- /Category List -->
                    <!-- Category list -->
                    <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                        <div class="category-block">
                            <div class="header">
                                <i class="fa fa-home icon-bg-3"></i>
                                <h4>ابرو</h4>
                            </div>

                        </div>
                    </div> <!-- /Category List -->
                    <!-- Category list -->
                    <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                        <div class="category-block">
                            <div class="header">
                                <i class="fa fa-shopping-basket icon-bg-4"></i>
                                <h4>مو</h4>
                            </div>

                        </div>
                    </div> <!-- /Category List -->


                </div>
            </div>
        </div>
    </div>
    <!-- Container End -->
</section>


<!--============================
=            Footer            =
=============================-->

<footer class="footer section section-sm" dir="rtl">
    <!-- Container Start -->
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-7 offset-md-1 offset-lg-0">
                <!-- About -->
                <div class="block about" align="right">
                    <!-- footer logo -->
                    <img src="http://pibeautysalon.com/wp-content/uploads/2021/01/pi_logo.png" alt="">
                    <!-- description -->
                    <p class="alt-color">پی‌سالن یک مرکز آرایشی و زیبایی است که اتمسفر متفاوتی رو برای خانم‌‌های فعال و پیشروی این جامعه تدارک دیده.   نکته مهم اینه که وقتی میاین آرایشگاه که به خودتون استراحت بدین، محیط در خور شأن و شخصیت شما باشه.   در پی‌سالن همه تلاشمون رو کردیم که این جو رو برای شما بسازیم.</p>
                </div>
            </div>
            <!-- Link list -->
            <div class="col-lg-2 offset-lg-1 col-md-3">
                <div class="block"  align="right">
                    <h4>اطلاعات</h4>
                    <ul>
                        <li><a href="http://pibeautysalon.com/contact-us/"  >تماس با ما</a></li>
                        <li><a href="http://pibeautysalon.com/faq/"  >سوالات رایج</a></li>
                        <li><a href="http://pibeautysalon.com/blog/" >بلاگ</a></li>

                    </ul>
                </div>
            </div>
            <!-- Link list -->
            <div class="col-lg-2 col-md-3 offset-md-1 offset-lg-0">
                <div class="block"  align="right">
                    <h4>حساب کاربری</h4>
                    <ul>
                        <li><a href="http://pibeautysalon.com/cart/"  >سبد خرید</a></li>




                    </ul>
                </div>
            </div>
            <!-- Promotion -->
            <div class="col-lg-4 col-md-7">

            </div>
        </div>
    </div>
    <!-- Container End -->
</footer>
<!-- Footer Bottom -->
<footer class="footer-bottom">
    <!-- Container Start -->
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-12">
                <!-- Copyright -->
                <div class="copyright">
                    <p>Copyright ©</p>
                </div>
            </div>
            <div class="col-sm-6 col-12">
                <!-- Social Icons
                <ul class="social-media-icons text-right">
                    <li><a class="fa fa-facebook" href="https://www.facebook.com/themefisher" target="_blank"></a></li>
                    <li><a class="fa fa-twitter" href="https://www.twitter.com/themefisher" target="_blank"></a></li>
                    <li><a class="fa fa-pinterest-p" href="https://www.pinterest.com/themefisher" target="_blank"></a></li>
                    <li><a class="fa fa-vimeo" href=""></a></li>
                </ul> -->
            </div>
        </div>
    </div>
    <!-- Container End -->
    <!-- To Top -->
    <div class="top-to">
        <a id="top" class="" href="#"><i class="fa fa-angle-up"></i></a>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!-- JAVASCRIPTS
<script src="<?= assets_url() ?>app-assets/front2/plugins/jQuery/jquery.min.js"></script> -->
<script src="<?= assets_url() ?>app-assets/front2/plugins/bootstrap/js/popper.min.js"></script>
<script src="<?= assets_url() ?>app-assets/front2/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= assets_url() ?>app-assets/front2/plugins/bootstrap/js/bootstrap-slider.js"></script>
<!-- tether js
<script src="<?= assets_url() ?>app-assets/front2/plugins/tether/js/tether.min.js"></script>
<script src="<?= assets_url() ?>app-assets/front2/plugins/raty/jquery.raty-fa.js"></script>
<script src="<?= assets_url() ?>app-assets/front2/plugins/slick-carousel/slick/slick.min.js"></script>
<script src="<?= assets_url() ?>app-assets/front2/plugins/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="<?= assets_url() ?>app-assets/front2/plugins/fancybox/jquery.fancybox.pack.js"></script>
<script src="<?= assets_url() ?>app-assets/front2/plugins/smoothscroll/SmoothScroll.min.js"></script>
-->
<script src="<?= assets_url() ?>app-assets/front2/js/script.js"></script>

<script type='text/javascript' src='https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js'></script>
<script type='text/javascript' src='https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

</script>
</body>

</html>



