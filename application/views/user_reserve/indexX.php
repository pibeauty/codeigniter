<!DOCTYPE html>
<html lang="en">
<head>

    <!-- SITE TITTLE -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Classimax</title>

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
                        <ul class="navbar-nav ml-auto main-nav ">
                            <li class="nav-item active">
                                <a class="nav-link" href="index.html">Home</a>
                            </li>
                            <li class="nav-item dropdown dropdown-slide">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="">Dashboard<span><i class="fa fa-angle-down"></i></span>
                                </a>

                                <!-- Dropdown list -->
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="dashboard.html">Dashboard</a>
                                    <a class="dropdown-item" href="dashboard-my-ads.html">Dashboard My Ads</a>
                                    <a class="dropdown-item" href="dashboard-favourite-ads.html">Dashboard Favourite Ads</a>
                                    <a class="dropdown-item" href="dashboard-archived-ads.html">Dashboard Archived Ads</a>
                                    <a class="dropdown-item" href="dashboard-pending-ads.html">Dashboard Pending Ads</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown dropdown-slide">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pages <span><i class="fa fa-angle-down"></i></span>
                                </a>
                                <!-- Dropdown list -->
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
                            </li>
                            <li class="nav-item dropdown dropdown-slide">
                                <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Listing <span><i class="fa fa-angle-down"></i></span>
                                </a>
                                <!-- Dropdown list -->
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="category.html">Ad-Gird View</a>
                                    <a class="dropdown-item" href="ad-listing-list.html">Ad-List View</a>
                                </div>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-auto mt-10">
                            <li class="nav-item">
                                <a class="nav-link login-button" href="login.html">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white add-button" href="ad-listing.html"><i class="fa fa-plus-circle"></i> Add Listing</a>
                            </li>
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
                    <h1>Buy & Sell Near You </h1>
                    <p>Join the millions who buy and sell from each other <br> everyday in local communities around the world</p>
                    <div class="short-popular-category-list text-center">
                        <h2>Popular Category</h2>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="category.html"><i class="fa fa-bed"></i> Hotel</a></li>
                            <li class="list-inline-item">
                                <a href="category.html"><i class="fa fa-grav"></i> Fitness</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="category.html"><i class="fa fa-car"></i> Cars</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="category.html"><i class="fa fa-cutlery"></i> Restaurants</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="category.html"><i class="fa fa-coffee"></i> Cafe</a>
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- Advance Search -->
                <div class="advance-search">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 col-md-12 align-content-center">
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control my-2 my-lg-1" id="inputtext4" placeholder="What are you looking for">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <select class="w-100 form-control mt-lg-1 mt-md-2">
                                                <option>Category</option>
                                                <option value="1">Top rated</option>
                                                <option value="2">Lowest Price</option>
                                                <option value="4">Highest Price</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="text" class="form-control my-2 my-lg-1" id="inputLocation4" placeholder="Location">
                                        </div>
                                        <div class="form-group col-md-2 align-self-center">
                                            <button type="submit" class="btn btn-primary">Search Now</button>
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


<!--===========================================
=            Popular deals section            =
============================================-->

<section class="popular-deals section bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h2>Trending Adds</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas, magnam.</p>

                    <select name="service[]" class="select-box " multiple="multiple">
                        <?php

                        foreach ($services as $row) {
                            $cid = $row->id;
                            $title = $row->name;
                            echo '<optgroup label="' . $title . '">';
                            foreach ($row->sub as $rowx) {
                                $cidx = $rowx->id;
                                $titlex = $rowx->name;
                                echo ' <option value="' . $cidx. '"> ' . $titlex . '</option>';
                            }
                            echo '</optgroup>';

                        }
                        ?>
                    </select>


                    <label for="Date" class="my-label-5">برای چه تاریخی میخواهید؟</label><br />
                    <input type="hidden" id="WeekNum" name="WeekNum"> <input type="hidden" id="setdateU" name="setdateU">
                    <input required type="text" name="setdatex" id="setdatex"    />


                </div>
            </div>
        </div>
        <div class="row">
            <!-- offer 01 -->
            <div class="col-lg-12">
                <div class="trending-ads-slide">
                    <div class="col-sm-12 col-lg-4">
                        <!-- product card -->
                        <div class="product-item bg-light">
                            <div class="card">
                                <div class="thumb-content">
                                    <!-- <div class="price">$200</div> -->
                                    <a href="single.html">
                                        <img class="card-img-top img-fluid" src="images/products/products-1.jpg" alt="Card image cap">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><a href="single.html">11inch Macbook Air</a></h4>
                                    <ul class="list-inline product-meta">
                                        <li class="list-inline-item">
                                            <a href="single.html"><i class="fa fa-folder-open-o"></i>Electronics</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#"><i class="fa fa-calendar"></i>26th December</a>
                                        </li>
                                    </ul>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!</p>
                                    <div class="product-ratings">
                                        <ul class="list-inline">
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <!-- product card -->
                        <div class="product-item bg-light">
                            <div class="card">
                                <div class="thumb-content">

                                    <!-- <div class="price">$200</div> -->
                                    <a href="single.html">
                                        <img class="card-img-top img-fluid" src="images/products/products-2.jpg" alt="Card image cap">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><a href="single.html">Full Study Table Combo</a></h4>
                                    <ul class="list-inline product-meta">
                                        <li class="list-inline-item">
                                            <a href="single.html"><i class="fa fa-folder-open-o"></i>Furnitures</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#"><i class="fa fa-calendar"></i>26th December</a>
                                        </li>
                                    </ul>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!</p>
                                    <div class="product-ratings">
                                        <ul class="list-inline">
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <!-- product card -->
                        <div class="product-item bg-light">
                            <div class="card">
                                <div class="thumb-content">
                                    <!-- <div class="price">$200</div> -->
                                    <a href="single.html">
                                        <img class="card-img-top img-fluid" src="images/products/products-3.jpg" alt="Card image cap">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><a href="single.html">11inch Macbook Air</a></h4>
                                    <ul class="list-inline product-meta">
                                        <li class="list-inline-item">
                                            <a href="single.html"><i class="fa fa-folder-open-o"></i>Electronics</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#"><i class="fa fa-calendar"></i>26th December</a>
                                        </li>
                                    </ul>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!</p>
                                    <div class="product-ratings">
                                        <ul class="list-inline">
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <!-- product card -->
                        <div class="product-item bg-light">
                            <div class="card">
                                <div class="thumb-content">
                                    <!-- <div class="price">$200</div> -->
                                    <a href="single.html">
                                        <img class="card-img-top img-fluid" src="images/products/products-2.jpg" alt="Card image cap">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><a href="single.html">Full Study Table Combo</a></h4>
                                    <ul class="list-inline product-meta">
                                        <li class="list-inline-item">
                                            <a href="single.html"><i class="fa fa-folder-open-o"></i>Furnitures</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#"><i class="fa fa-calendar"></i>26th December</a>
                                        </li>
                                    </ul>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!</p>
                                    <div class="product-ratings">
                                        <ul class="list-inline">
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>


        </div>
    </div>
</section>



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
                    <h2>All Categories</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis, provident!</p>
                </div>
                <div class="row">
                    <!-- Category list -->
                    <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                        <div class="category-block">
                            <div class="header">
                                <i class="fa fa-laptop icon-bg-1"></i>
                                <h4>Electronics</h4>
                            </div>
                            <ul class="category-list" >
                                <li><a href="category.html">Laptops <span>93</span></a></li>
                                <li><a href="category.html">Iphone <span>233</span></a></li>
                                <li><a href="category.html">Microsoft  <span>183</span></a></li>
                                <li><a href="category.html">Monitors <span>343</span></a></li>
                            </ul>
                        </div>
                    </div> <!-- /Category List -->
                    <!-- Category list -->
                    <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                        <div class="category-block">
                            <div class="header">
                                <i class="fa fa-apple icon-bg-2"></i>
                                <h4>Restaurants</h4>
                            </div>
                            <ul class="category-list" >
                                <li><a href="category.html">Cafe <span>393</span></a></li>
                                <li><a href="category.html">Fast food <span>23</span></a></li>
                                <li><a href="category.html">Restaurants  <span>13</span></a></li>
                                <li><a href="category.html">Food Track<span>43</span></a></li>
                            </ul>
                        </div>
                    </div> <!-- /Category List -->
                    <!-- Category list -->
                    <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                        <div class="category-block">
                            <div class="header">
                                <i class="fa fa-home icon-bg-3"></i>
                                <h4>Real Estate</h4>
                            </div>
                            <ul class="category-list" >
                                <li><a href="category.html">Farms <span>93</span></a></li>
                                <li><a href="category.html">Gym <span>23</span></a></li>
                                <li><a href="category.html">Hospitals  <span>83</span></a></li>
                                <li><a href="category.html">Parolurs <span>33</span></a></li>
                            </ul>
                        </div>
                    </div> <!-- /Category List -->
                    <!-- Category list -->
                    <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                        <div class="category-block">
                            <div class="header">
                                <i class="fa fa-shopping-basket icon-bg-4"></i>
                                <h4>Shoppings</h4>
                            </div>
                            <ul class="category-list" >
                                <li><a href="category.html">Mens Wears <span>53</span></a></li>
                                <li><a href="category.html">Accessories <span>212</span></a></li>
                                <li><a href="category.html">Kids Wears <span>133</span></a></li>
                                <li><a href="category.html">It & Software <span>143</span></a></li>
                            </ul>
                        </div>
                    </div> <!-- /Category List -->
                    <!-- Category list -->
                    <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                        <div class="category-block">
                            <div class="header">
                                <i class="fa fa-briefcase icon-bg-5"></i>
                                <h4>Jobs</h4>
                            </div>
                            <ul class="category-list" >
                                <li><a href="category.html">It Jobs <span>93</span></a></li>
                                <li><a href="category.html">Cleaning & Washing <span>233</span></a></li>
                                <li><a href="category.html">Management  <span>183</span></a></li>
                                <li><a href="category.html">Voluntary Works <span>343</span></a></li>
                            </ul>
                        </div>
                    </div> <!-- /Category List -->
                    <!-- Category list -->
                    <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                        <div class="category-block">
                            <div class="header">
                                <i class="fa fa-car icon-bg-6"></i>
                                <h4>Vehicles</h4>
                            </div>
                            <ul class="category-list" >
                                <li><a href="category.html">Bus <span>193</span></a></li>
                                <li><a href="category.html">Cars <span>23</span></a></li>
                                <li><a href="category.html">Motobike  <span>33</span></a></li>
                                <li><a href="category.html">Rent a car <span>73</span></a></li>
                            </ul>
                        </div>
                    </div> <!-- /Category List -->
                    <!-- Category list -->
                    <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                        <div class="category-block">
                            <div class="header">
                                <i class="fa fa-paw icon-bg-7"></i>
                                <h4>Pets</h4>
                            </div>
                            <ul class="category-list" >
                                <li><a href="category.html">Cats <span>65</span></a></li>
                                <li><a href="category.html">Dogs <span>23</span></a></li>
                                <li><a href="category.html">Birds  <span>113</span></a></li>
                                <li><a href="category.html">Others <span>43</span></a></li>
                            </ul>
                        </div>
                    </div> <!-- /Category List -->
                    <!-- Category list -->
                    <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                        <div class="category-block">

                            <div class="header">
                                <i class="fa fa-laptop icon-bg-8"></i>
                                <h4>Services</h4>
                            </div>
                            <ul class="category-list" >
                                <li><a href="category.html">Cleaning <span>93</span></a></li>
                                <li><a href="category.html">Car Washing <span>233</span></a></li>
                                <li><a href="category.html">Clothing  <span>183</span></a></li>
                                <li><a href="category.html">Business <span>343</span></a></li>
                            </ul>
                        </div>
                    </div> <!-- /Category List -->


                </div>
            </div>
        </div>
    </div>
    <!-- Container End -->
</section>


<!--====================================
=            Call to Action            =
=====================================-->

<section class="call-to-action overly bg-3 section-sm">
    <!-- Container Start -->
    <div class="container">
        <div class="row justify-content-md-center text-center">
            <div class="col-md-8">
                <div class="content-holder">
                    <h2>Start today to get more exposure and
                        grow your business</h2>
                    <ul class="list-inline mt-30">
                        <li class="list-inline-item"><a class="btn btn-main" href="ad-listing.html">Add Listing</a></li>
                        <li class="list-inline-item"><a class="btn btn-secondary" href="category.html">Browser Listing</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Container End -->
</section>

<!--============================
=            Footer            =
=============================-->

<footer class="footer section section-sm">
    <!-- Container Start -->
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-7 offset-md-1 offset-lg-0">
                <!-- About -->
                <div class="block about">
                    <!-- footer logo -->
                    <img src="images/logo-footer.png" alt="">
                    <!-- description -->
                    <p class="alt-color">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
            </div>
            <!-- Link list -->
            <div class="col-lg-2 offset-lg-1 col-md-3">
                <div class="block">
                    <h4>Site Pages</h4>
                    <ul>
                        <li><a href="#">Boston</a></li>
                        <li><a href="#">How It works</a></li>
                        <li><a href="#">Deals & Coupons</a></li>
                        <li><a href="#">Articls & Tips</a></li>
                        <li><a href="terms-condition.html">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>
            <!-- Link list -->
            <div class="col-lg-2 col-md-3 offset-md-1 offset-lg-0">
                <div class="block">
                    <h4>Admin Pages</h4>
                    <ul>
                        <li><a href="category.html">Category</a></li>
                        <li><a href="single.html">Single Page</a></li>
                        <li><a href="store.html">Store Single</a></li>
                        <li><a href="single-blog.html">Single Post</a>
                        </li>
                        <li><a href="blog.html">Blog</a></li>



                    </ul>
                </div>
            </div>
            <!-- Promotion -->
            <div class="col-lg-4 col-md-7">
                <!-- App promotion -->
                <div class="block-2 app-promotion">
                    <div class="mobile d-flex">
                        <a href="">
                            <!-- Icon -->
                            <img src="images/footer/phone-icon.png" alt="mobile-icon">
                        </a>
                        <p>Get the Dealsy Mobile App and Save more</p>
                    </div>
                    <div class="download-btn d-flex my-3">
                        <a href="#"><img src="images/apps/google-play-store.png" class="img-fluid" alt=""></a>
                        <a href="#" class=" ml-3"><img src="images/apps/apple-app-store.png" class="img-fluid" alt=""></a>
                    </div>
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
                    <p>Copyright © <script>
                            var CurrentYear = new Date().getFullYear()
                            document.write(CurrentYear)
                        </script>. All Rights Reserved, theme by <a class="text-primary" href="https://themefisher.com" target="_blank">themefisher.com</a></p>
                </div>
            </div>
            <div class="col-sm-6 col-12">
                <!-- Social Icons -->
                <ul class="social-media-icons text-right">
                    <li><a class="fa fa-facebook" href="https://www.facebook.com/themefisher" target="_blank"></a></li>
                    <li><a class="fa fa-twitter" href="https://www.twitter.com/themefisher" target="_blank"></a></li>
                    <li><a class="fa fa-pinterest-p" href="https://www.pinterest.com/themefisher" target="_blank"></a></li>
                    <li><a class="fa fa-vimeo" href=""></a></li>
                </ul>
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
    $(function () {
        $('.select-box').select2();
    });

    $('.setdatex').persianDatepicker({
        minDate: new persianDate().unix(),
        format: 'YYYY/MM/DD',
        autoClose: true,
        initialValue: false,
        onSelect: function(unix){
            var date = new Date(unix);
            //date.setHours(0);date.setMinutes(0);date.setSeconds(0);
            date.setHours(0,0,0,0);
            document.getElementById("WeekNum").value=new persianDate(unix).day();
            document.getElementById("setdateU").value=date.getTime();
            console.log('datepicker select : ' + date.getTime());
        }
    });
</script>
</body>

</html>



