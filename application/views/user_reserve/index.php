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
    <link rel='stylesheet' href='https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css' type='text/css' />

    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  -->
    <link href="<?= assets_url() ?>app-assets/front2/plugins/select2/select2.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= assets_url() ?>app-assets/front2/css/user_reserve.css">

    <style>
        input,
        select,
        textarea {
            color: #000 !important;
        }

        input {
            border: 1px solid darkgrey !important;
            border-radius: 5px !important;
        }

        input:focus {
            border: 1px solid black !important;
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
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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



    <section class="hero-area bg-5 text-center overly">
        <!-- Container Start -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Header Contetnt -->
                    <div class="content-block">
                        <img src=<?php echo base_url("assets/images/logo.png") ?> alt="logo" style="max-width:200px">
                        <!-- <h1>پی سالن </h1> -->
                        <!-- <p>نمایش زیبایی درون و بیرون ِ زنان پیشروی جامعه در برند پی</p> -->
                    </div>
                    <!-- Advance Search -->
                    <div class="container">
                        <article>
                            <ol style="list-style:arabic-indic; direction:rtl; text-align:right">
                                <li>
                                     لطفاً اطلاعات خود را به درستی وارد کنید.(درست بودن شماره تماس شما بسیار مهم است.)
                                </li>
                                <li>
                                     در انتخاب روز و ساعت مورد نظرتان دقت نمایید تا فرایند وقت دهی شما دچار مشکل نشود. دقت داشته باشید که سالن در روزهای دوشنبه و جمعه تعطیل است.
                                </li>
                                <li>
                                     پس از رزرو آنلاین از طرف سالن با شما تماس گرفته خواهد شد. در صورت عدم دریافت تماس، رزرو شما قطعی نیست.
                                </li>
                                <li>
                                    برای تغییر روز و ساعتی که به صورت آنلاین رزرو کرده‌اید لطفا با سالن تماس بگیرید. امکان تغییر زمان به صورت آنلاین برای شما وجود نخواهد داشت. شماره تماس سالن:  ۴۰۲۲۰۰۱۲
                                </li>
                                <li>
                                     در صورت رزرو وقت و عدم مراجعه هزینه پرداختی شما به کیف پولتان منتقل خواهد شد.
                                </li>
                                <li>
                                    در صورتی که در مورد خدمت انتخابی خود سوالی دارید، ابتدا با سالن تماس گرفته و‌ مشاوره بگیرید.
                                </li>
                            </ol>
                        </article>
                    </div>
                    <div class="advance-search">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-md-12 align-content-center">
                                    <form action="<?php echo base_url() . 'user_reserve/employees' ?>" method="post">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                        <div class="form-row" dir="rtl">
                                            <div class="form-group col-md-6">
                                                <label for="name"></label>
                                                <input type="text" class="form-control my-2 my-lg-1" id="name" name="name" placeholder="نام و نام خانودگی" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="mobile"></label>
                                                <input type="number" class="form-control my-2 my-lg-1" id="mobile" name="mobile" min="09000000000" max="09999999999" placeholder="موبایل (انگلیسی)" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="hidden" id="WeekNum" name="WeekNum" required>
                                                <input type="hidden" id="setdateU" name="setdateU" required>
                                                <label for="setdate"></label>
                                                <input style="margin-top: -2px!important; background-color: white;" autocomplete="off" readonly type="text" name="setdate" id="setdate" class="setdate form-control my-2 my-lg-1" placeholder=" تاریخ" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputtext4"></label>
                                                <select id='main_services' name="mainServices[]" class="select-box form-control my-2 my-lg-1">
                                                    <option></option>
                                                </select>
                                                <select id='sub_services' name="subServices[]" class="select-box form-control my-2 my-lg-1">
                                                    <option></option>
                                                </select>
                                                <select id='services' name="services[]" class="select-box form-control my-2 my-lg-1" multiple="multiple" required>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="referrer"></label>
                                                <input type="text" class="form-control my-2 my-lg-1" id="referrerCode" name="referrerCode" placeholder="معرف">
                                            </div>

                                            <div class="form-group col-md-12 align-self-center" align="center">
                                                <button type="submit" class="btn btn-primary" style="background: #c29e76;border:solid 1px #c29e76;">تایید و ادامه</button>
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

    <section class=" section" style="background: rgb(151 204 196);">
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
                                <!-- <div class="header"> -->
                                <div>
                                    <!-- <i class="fa fa-laptop icon-bg-1"></i>
                                <h4>مانیکور</h4> -->
                                    <img src=<?php echo base_url('/app-assets/images/user_reserve/3.jpg') ?> style="max-width: 100%;">
                                </div>

                            </div>
                        </div> <!-- /Category List -->
                        <!-- Category list -->
                        <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                            <div class="category-block">
                                <!-- <div class="header"> -->
                                <div>
                                    <!-- <i class="fa fa-apple icon-bg-2"></i>
                                <h4>پدیکور</h4> -->
                                    <img src=<?php echo base_url('/app-assets/images/user_reserve/IMG_2936.jpg') ?> style="max-width: 100%;">
                                </div>
                            </div>
                        </div> <!-- /Category List -->
                        <!-- Category list -->
                        <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                            <div class="category-block">
                                <!-- <div class="header"> -->
                                <div>
                                    <!-- <i class="fa fa-home icon-bg-3"></i>
                                <h4>ابرو</h4> -->
                                    <img src=<?php echo base_url('/app-assets/images/user_reserve/1.jpg') ?> style="max-width: 100%;">
                                </div>

                            </div>
                        </div> <!-- /Category List -->
                        <!-- Category list -->
                        <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                            <div class="category-block">
                                <!-- <div class="header"> -->
                                <div>
                                    <!-- <i class="fa fa-shopping-basket icon-bg-4"></i>
                                <h4>مو</h4> -->
                                    <img src=<?php echo base_url('/app-assets/images/user_reserve/2.jpg') ?> style="max-width: 100%;">
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

    <style>
        .footer .block {
            height: 100%;
            display: flex;
            justify-content: center;
            /* align horizontal */
            align-items: center;
            /* align vertical */
        }

        .footer .block p {
            font-size: 1em;
        }

        .footer .block i {
            padding: 0.5em
        }
    </style>

    <footer class="footer section section-sm" dir="rtl">
        <!-- Container Start -->
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 offset-lg-0">
                    <!-- About -->
                    <div class="block about" align="right">
                        <!-- footer logo -->
                        <img src=<?php echo base_url("assets/images/logo.png") ?> alt="logo" style="max-width:200px">
                        <!-- <img src="http://pibeautysalon.com/wp-content/uploads/2021/01/pi_logo.png" alt=""> -->
                        <!-- description -->
                        <!-- <p class="alt-color">پی‌سالن یک مرکز آرایشی و زیبایی است که اتمسفر متفاوتی رو برای خانم‌‌های فعال و پیشروی این جامعه تدارک دیده.   نکته مهم اینه که وقتی میاین آرایشگاه که به خودتون استراحت بدین، محیط در خور شأن و شخصیت شما باشه.   در پی‌سالن همه تلاشمون رو کردیم که این جو رو برای شما بسازیم.</p> -->
                    </div>
                </div>
                <!-- Link list -->
                <div class="col-lg-3 col-md-6">
                    <div class="block" align="right">
                        <p><i class="fa fa-map-marker" aria-hidden="true"></i>فرمانیه، مرکز خرید سانا، طبقه ششم، واحد ۶۰۲</p>
                        <!-- <h4>اطلاعات</h4>
                    <ul>
                        <li><a href="http://pibeautysalon.com/contact-us/"  >تماس با ما</a></li>
                        <li><a href="http://pibeautysalon.com/faq/"  >سوالات رایج</a></li>
                        <li><a href="http://pibeautysalon.com/blog/" >بلاگ</a></li>

                    </ul> -->
                    </div>
                </div>
                <!-- Link list -->
                <div class="col-lg-3 col-md-6 offset-lg-0">
                    <div class="block" align="right">
                        <p><i class="fa fa-phone-square" aria-hidden="true"></i>۴۰۲−۲۰۰۱۲</p>
                        <!-- <h4>حساب کاربری</h4>
                    <ul>
                        <li><a href="http://pibeautysalon.com/cart/"  >سبد خرید</a></li>




                    </ul> -->
                    </div>
                </div>
                <!-- Promotion -->
                <div class="col-lg-3 col-md-6">
                    <div class="block" align="right">
                        <p><i class="fa fa-instagram" aria-hidden="true"></i>pibeautysalon</p>
                    </div>
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

    <script type="text/javascript" src="<?= assets_url() ?>app-assets/vendors/js/persian-datepicker/persian-date.min.js"></script>
    <script type="text/javascript" src="<?= assets_url() ?>app-assets/vendors/js/persian-datepicker/persian-datepicker.min.js"></script>
    <script type="text/javascript" src="<?= assets_url() ?>app-assets/vendors/js/persian-datepicker/select2.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
    <script>
        <?php
        $servicesObj = [];
        $subServicesObj = [];
        foreach ($services as $row) {
            array_push($servicesObj, ['id' => $row->id, 'text' => $row->name]);
            foreach ($row->sub as $rowx) {
                array_push($subServicesObj, ['id' => $rowx->id, 'text' => $rowx->name, 'main_service_id' => $row->id]);
            }
        }
        $servicesObj = json_encode($servicesObj);
        $subServicesObj = json_encode($subServicesObj);
        ?>
        var mainServices = JSON.parse('<?= $servicesObj ?>')
        var subServices = JSON.parse('<?= $subServicesObj ?>')
        $(document).ready(function() {
            // $('.select-box').select2({
            //     placeholder: "خدمات"
            // });
            $("#main_services").select2({
                placeholder: "خدمات اصلی",
                data: mainServices
            })
            $("#sub_services").select2({
                placeholder: "زیرگروه خدمات"
            }).prop("disabled", true);
            $("#services").select2()
            $("#services").on("select2:opening", function(e) {
                e.preventDefault()
            })
            $("#services").on("select2:unselect", function(e) {
                $('#services').find("option[value='" + e.params.data.id + "']").remove()
            })
            $('#services').on('select2:opening select2:closing', function(event) {
                const $searchfield = $(this).parent().find('.select2-search__field');
                $searchfield.prop('disabled', true);
            });
            $("#main_services").on("change", function(e) {
                const selectedService = e.target.value
                const filteredSubservice = [{
                    id: "-1",
                    text: 'لطفا انتخاب کنید',
                    disabled: true,
                    selected: true
                }].concat(window.subServices.filter(elem => elem.main_service_id == selectedService))
                const subServiceElem = $("#sub_services")
                subServiceElem.prop("disabled", false);
                subServiceElem.empty()
                subServiceElem.select2({
                    data: filteredSubservice
                })
                subServiceElem.trigger('change');
            })
        });
        $("#sub_services").on('select2:select', function(e) {
            const selected = e.target.selectedOptions[0]
            if ($('#services').find("option[value='" + selected.value + "']").length == 0) {
                const newOption = new Option(selected.text, selected.value, false, true);
                $("#services").append(newOption).trigger('change');
            }
            $("#main_services").val(null).trigger('change')
            $("#sub_services").select2({
                placeholder: "زیرگروه خدمات"
            }).prop("disabled", true);
        })
        $('.setdate').persianDatepicker({
            // minDate: new persianDate().unix(),
            minDate: Date.now(),
            format: 'dddd, DD MMMM ',
            autoClose: true,
            initialValue: Date.now(),
            onSelect: function(unix) {
                var date = new Date(unix);
                //date.setHours(0);date.setMinutes(0);date.setSeconds(0);
                date.setHours(0, 0, 0, 0);
                document.getElementById("WeekNum").value = new persianDate(unix).day();
                document.getElementById("setdateU").value = date.getTime();
            }
        });
        const nowUnix = Date.now();
        const date = new Date(nowUnix);
        date.setHours(0, 0, 0, 0);
        document.getElementById("WeekNum").value = new persianDate(nowUnix).day();
        document.getElementById("setdateU").value = date.getTime();
    </script>
</body>

</html>