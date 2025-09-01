<?php include('views/view.head.php'); ?>

<body class="custom-cursor">

    <div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div>

    <div class="preloader">
        <div class="preloader__image" style="background-image: url(assets/images/loader.png);"></div>
    </div>
    <!-- /.preloader -->
    <div class="page-wrapper">
        <div class="main-header">
            <?php include('views/view.topbar.php'); ?>
            <?php include('views/view.header.php'); ?>
        </div>

        <!-- main-banner-start -->
        <section class="banner-one" style="background-image: url(assets/images/shapes/banner-1-1.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 wow fadeInUp" data-wow-delay="300ms">
                        <h2 class="banner-one__title">Welcome to Gunasewana surf house</h2>
                    </div>
                    
                </div>
            </div>
        </section>
        <section class="banner-form wow fadeInUp" data-wow-delay="300ms">
            <div class="banner-form__carousel villoz-owl__carousel owl-carousel owl-theme" data-owl-options='{
		"items": 1,
		"margin": 0,
		"loop": true,
		"smartSpeed": 700,
		"animateOut": "fadeOut",
		"autoplayTimeout": 5000, 
		"nav": false,
		"dots": false,
		"autoplay": true
		}'>
                <div class="item">
                    <div class="banner-form__image" style="background-image: url(assets/images/backgrounds/slider-1-1.jpg);"></div>
                </div>
                <div class="item">
                    <div class="banner-form__image" style="background-image: url(assets/images/backgrounds/slider-1-2.jpg);"></div>
                </div>
                <div class="item">
                    <div class="banner-form__image" style="background-image: url(assets/images/backgrounds/slider-1-3.jpg);"></div>
                </div>
            </div><!-- banner slider -->
            <div class="banner-form__position wow fadeInUp" data-wow-delay="300ms">
                <div class="container">
                    <form class="banner-form__wrapper" action="book-room.php" method="get">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="banner-form__control">
                                    <label for="package">Package</label>
                                    <select name="package" class="selectpicker" id="package">
                                        <option value="select">Select Package</option>
                                        <?php 
                                            $packagesList = $packages->fetchPackages();

                                            foreach ($packagesList as $package) {
                                                echo '<option value="'.$package['package_id'].'">'.$package['package_name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                    <i class="icon-package"></i>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="banner-form__control">
                                    <label for="checkin">Checkin</label>
                                    <input class="villoz-datepicker" id="checkin" type="text" name="checkin" placeholder="Add Date">
                                    <i class="icon-calendar"></i>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="banner-form__control">
                                    <label for="checkout">Checkout</label>
                                    <input class="villoz-datepicker" id="checkout" type="text" name="checkout" placeholder="Add Date">
                                    <i class="icon-calendar"></i>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="banner-form__control">
                                    <label for="guests">Guests</label>
                                    <button type="submit" class="banner-form__qty-minus sub">
                                        <i class="icon-minus-1"></i>
                                    </button>
                                    <input id="guests" type="number" value="0" name="guests" placeholder="0">
                                    <button type="submit" class="banner-form__qty-plus add">
                                        <i class="icon-plus-1"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <button type="submit" aria-label="search submit" class="villoz-btn villoz-btn--base">
                                    <i><i class="icon-magnifying-glass"></i></i>
                                    <span><i class="icon-magnifying-glass"></i></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- main-banner-end -->
        <!-- Service Start -->
        <section class="service-one">
            <div class="container">
                <div class="sec-title text-center">
                    <h6 class="sec-title__tagline">AMENITIES & SERVICES</h6>
                    <h3 class="sec-title__title">Offer the Best Services <br>to Your Stay</h3>
                </div>
                <div class="service-one__carousel villoz-owl__carousel villoz-owl__carousel--basic-nav owl-carousel owl-theme" data-owl-options='{
			"items": 1,
			"margin": 30,
			"loop": false,
			"smartSpeed": 700,
			"nav": false,
			"navText": ["<span class=\"fa fa-angle-left\"></span>","<span class=\"fa fa-angle-right\"></span>"],
			"dots": true,
			"autoplay": false,
			"responsive": {
				"0": {
					"items": 1
				},
				"768": {
					"items": 2
				},
				"992": {
					"items": 3
				},
				"1300": {
					"items": 4
				}
			}
			}'>
                    <div class="item">
                        <div class="service-one__item wow fadeInUp" data-wow-delay="100ms">
                            <div class="service-one__image">
                                <img src="assets/images/resources/service-1-1.jpg" alt="villoz">
                            </div>
                            <div class="service-one__content">
                                <a class="service-one__content__rm" href="#"><span class="icon-right-arrow"></span></a>
                                <h3 class="service-one__content__title">Private Chef</h3>
                                <p class="service-one__content__text">Need to add descriptions here</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="service-one__item wow fadeInUp" data-wow-delay="200ms">
                            <div class="service-one__image">
                                <img src="assets/images/resources/service-1-2.jpg" alt="villoz">
                            </div>
                            <div class="service-one__content">
                                <a class="service-one__content__rm" href="#"><span class="icon-right-arrow"></span></a>
                                <h3 class="service-one__content__title">Quality Gym</h3>
                                <p class="service-one__content__text">Need to add descriptions here</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="service-one__item wow fadeInUp" data-wow-delay="300ms">
                            <div class="service-one__image">
                                <img src="assets/images/resources/service-1-3.jpg" alt="villoz">
                            </div>
                            <div class="service-one__content">
                                <a class="service-one__content__rm" href="#"><span class="icon-right-arrow"></span></a>
                                <h3 class="service-one__content__title">Housekeeping</h3>
                                <p class="service-one__content__text">Need to add descriptions here</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="service-one__item wow fadeInUp" data-wow-delay="400ms">
                            <div class="service-one__image">
                                <img src="assets/images/resources/service-1-4.jpg" alt="villoz">
                            </div>
                            <div class="service-one__content">
                                <a class="service-one__content__rm" href="#"><span class="icon-right-arrow"></span></a>
                                <h3 class="service-one__content__title">Spa & Wellness</h3>
                                <p class="service-one__content__text">Need to add descriptions here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Service End -->
        <section class="about-one">
            <div class="about-one__shape villoz-splax" data-para-options='{"orientation": "left", "scale": 1.5, "delay": ".5", "transition": "cubic-bezier(0,0,0,1)", "overflow": true
        }'><img src="assets/images/resources/about-1-plan.png" alt="villoz" />
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="about-one__content wow fadeInLeft" data-wow-delay="300ms">
                            <div class="sec-title text-left">

                                <h6 class="sec-title__tagline">Welcome to Gunasewana Surf House</h6>

                                <h3 class="sec-title__title">Get to Know About Gunasewana Surf House</h3>
                            </div>
                            <div class="about-one__content__map"><img src="assets/images/resources/about-1-map.png" alt="villoz"></div>
                            <div class="row">
                                <div class="col-lg-5 col-md-6">
                                    <div class="about-one__image-one">
                                        <img src="assets/images/resources/about-1-1.jpg" alt="villoz">
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-6">
                                    <div class="about-one__content-inner">
                                        <h5 class="about-one__content-inner__title">We’re Providing a Great service for eveyone stays with us.</h5>
                                        <p class="about-one__content-inner__text">
                                            Need to add description about Gunasewana
                                        </p>
                                        <ul class="about-one__content-inner__list">
                                            <li><span class="fa fa-check-circle"></span>Guarantee happiness</li>
                                            <li><span class="fa fa-check-circle"></span>Search & book the best</li>
                                            <li><span class="fa fa-check-circle"></span>Most luxury villas available</li>
                                            <li><span class="fa fa-check-circle"></span>Premier choice for vacation rentals</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 wow fadeInRight" data-wow-delay="300ms">
                        <div class="about-one__right">
                            <div class="about-one__circle">
                                <div class="about-one__circle__icon"><span class="icon-best-seller"></span></div>
                                <!-- <div class="curved-circle">
                                    <div class="curved-circle--item" data-circle-text-options='{
                                        "radius": 95,
                                        "forceWidth": true,
                                        "forceHeight": true
                                    }'>Gunasewana Surf House</div>
                                </div> -->
                            </div>
                            <div class="about-one__image-two">
                                <img src="assets/images/resources/about-1-2.jpg" alt="villoz">
                            </div>
                            <ul class="list-unstyled about-one__facts">
                                <li class="about-one__facts__item count-box">
                                    <div class="about-one__facts__icon"><span class="icon-villa-1"></span></div>
                                    <h3 class="about-one__facts__count count-text" data-stop="2270" data-speed="1500"></h3>
                                    <p class="about-one__facts__text">Villas on Rent</p>
                                </li>
                                <li class="about-one__facts__item count-box">
                                    <div class="about-one__facts__icon"><span class="icon-map"></span></div>
                                    <h3 class="about-one__facts__count count-text" data-stop="289" data-speed="1500"></h3>
                                    <p class="about-one__facts__text">Top Destination</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        
        <section class="testimonials-one" style="background-image: url(assets/images/backgrounds/testimonial-bg-1.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="testimonials-one__content">
                            <div class="sec-title text-left">

                                <h6 class="sec-title__tagline">Guest reviews</h6><!-- /.sec-title__tagline -->

                                <h3 class="sec-title__title">What Guests Saying?</h3><!-- /.sec-title__title -->
                            </div><!-- /.sec-title -->
                            <div class="testimonials-one__content__ratings">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div><!-- /.testimonials-average__ratings -->
                            <p class="testimonials-one__content__text">Trust Score 4.5 (Based on 2,500 Reviews)</p>
                            <div class="testimonials-one__carousel-dots"></div><!-- /.testimonials-custome-dots -->
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="testimonials-one__carousel villoz-owl__carousel villoz-owl__carousel--with-shadow owl-carousel" data-owl-options='{
					"items": 1,
					"margin": 30,
					"loop": false,
					"smartSpeed": 700,
					"nav": false,
					"navText": ["<span class=\"fa fa-angle-left\"></span>","<span class=\"fa fa-angle-right\"></span>"],
					"dots": true,
					"dotsContainer": ".testimonials-one__carousel-dots",
					"autoplay": false,
					"responsive": {
						"0": {
							"items": 1
						},
						"768": {
							"items": 2
						}
					}
					}'>
                            <div class="item">
                                <div class="testimonials-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='000ms'>
                                    <div class="testimonials-card__top-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-1.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div><!-- /.testimonials-card__rating -->
                                    <div class="testimonials-card__content">
                                        Lorem ipsum is simply free dolor not sit amet, notted adipisicing elit sed do eiusmod incididunt labore et dolore text.
                                    </div><!-- /.testimonials-card__content -->
                                    <div class="testimonials-card__author">
                                        <img src="assets/images/resources/testi-1-1.jpg" alt="Mike Hardson">
                                        <h3 class="testimonials-card__name">
                                            Mike Hardson
                                        </h3><!-- /.testimonials-card__name -->
                                        <p class="testimonials-card__designation">CEO - Co Founder</p><!-- /.testimonials-card__designation -->
                                    </div><!-- /.testimonials-card__image -->
                                    <div class="testimonials-card__bottom-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-2.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__bottom-bg-hover" style="background-image: url(assets/images/shapes/testi-card-bg-1-2-hover.png);"></div><!-- /.testimonials-card__top-bg -->
                                </div><!-- /.testimonials-card -->
                            </div><!-- /.item -->
                            <div class="item">
                                <div class="testimonials-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='100ms'>
                                    <div class="testimonials-card__top-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-1.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div><!-- /.testimonials-card__rating -->
                                    <div class="testimonials-card__content">
                                        Lorem ipsum is simply free dolor not sit amet, notted adipisicing elit sed do eiusmod incididunt labore et dolore text.
                                    </div><!-- /.testimonials-card__content -->
                                    <div class="testimonials-card__author">
                                        <img src="assets/images/resources/testi-1-2.jpg" alt="Alesha Brown">
                                        <h3 class="testimonials-card__name">
                                            Alesha Brown
                                        </h3><!-- /.testimonials-card__name -->
                                        <p class="testimonials-card__designation">Co Founder</p><!-- /.testimonials-card__designation -->
                                    </div><!-- /.testimonials-card__image -->
                                    <div class="testimonials-card__bottom-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-2.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__bottom-bg-hover" style="background-image: url(assets/images/shapes/testi-card-bg-1-2-hover.png);"></div><!-- /.testimonials-card__top-bg -->
                                </div><!-- /.testimonials-card -->
                            </div><!-- /.item -->
                            <div class="item">
                                <div class="testimonials-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='200ms'>
                                    <div class="testimonials-card__top-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-1.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div><!-- /.testimonials-card__rating -->
                                    <div class="testimonials-card__content">
                                        Lorem ipsum is simply free dolor not sit amet, notted adipisicing elit sed do eiusmod incididunt labore et dolore text.
                                    </div><!-- /.testimonials-card__content -->
                                    <div class="testimonials-card__author">
                                        <img src="assets/images/resources/testi-1-3.jpg" alt="Kevin Martin">
                                        <h3 class="testimonials-card__name">
                                            Kevin Martin
                                        </h3><!-- /.testimonials-card__name -->
                                        <p class="testimonials-card__designation">Developer</p><!-- /.testimonials-card__designation -->
                                    </div><!-- /.testimonials-card__image -->
                                    <div class="testimonials-card__bottom-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-2.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__bottom-bg-hover" style="background-image: url(assets/images/shapes/testi-card-bg-1-2-hover.png);"></div><!-- /.testimonials-card__top-bg -->
                                </div><!-- /.testimonials-card -->
                            </div><!-- /.item -->
                            <div class="item">
                                <div class="testimonials-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='300ms'>
                                    <div class="testimonials-card__top-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-1.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div><!-- /.testimonials-card__rating -->
                                    <div class="testimonials-card__content">
                                        Lorem ipsum is simply free dolor not sit amet, notted adipisicing elit sed do eiusmod incididunt labore et dolore text.
                                    </div><!-- /.testimonials-card__content -->
                                    <div class="testimonials-card__author">
                                        <img src="assets/images/resources/testi-1-4.jpg" alt="Mark Smith">
                                        <h3 class="testimonials-card__name">
                                            Mark Smith
                                        </h3><!-- /.testimonials-card__name -->
                                        <p class="testimonials-card__designation">Reviwer</p><!-- /.testimonials-card__designation -->
                                    </div><!-- /.testimonials-card__image -->
                                    <div class="testimonials-card__bottom-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-2.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__bottom-bg-hover" style="background-image: url(assets/images/shapes/testi-card-bg-1-2-hover.png);"></div><!-- /.testimonials-card__top-bg -->
                                </div><!-- /.testimonials-card -->
                            </div><!-- /.item -->
                            <div class="item">
                                <div class="testimonials-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='000ms'>
                                    <div class="testimonials-card__top-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-1.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div><!-- /.testimonials-card__rating -->
                                    <div class="testimonials-card__content">
                                        Lorem ipsum is simply free dolor not sit amet, notted adipisicing elit sed do eiusmod incididunt labore et dolore text.
                                    </div><!-- /.testimonials-card__content -->
                                    <div class="testimonials-card__author">
                                        <img src="assets/images/resources/testi-1-1.jpg" alt="Mike Hardson">
                                        <h3 class="testimonials-card__name">
                                            Mike Hardson
                                        </h3><!-- /.testimonials-card__name -->
                                        <p class="testimonials-card__designation">CEO - Co Founder</p><!-- /.testimonials-card__designation -->
                                    </div><!-- /.testimonials-card__image -->
                                    <div class="testimonials-card__bottom-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-2.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__bottom-bg-hover" style="background-image: url(assets/images/shapes/testi-card-bg-1-2-hover.png);"></div><!-- /.testimonials-card__top-bg -->
                                </div><!-- /.testimonials-card -->
                            </div><!-- /.item -->
                            <div class="item">
                                <div class="testimonials-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='100ms'>
                                    <div class="testimonials-card__top-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-1.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div><!-- /.testimonials-card__rating -->
                                    <div class="testimonials-card__content">
                                        Lorem ipsum is simply free dolor not sit amet, notted adipisicing elit sed do eiusmod incididunt labore et dolore text.
                                    </div><!-- /.testimonials-card__content -->
                                    <div class="testimonials-card__author">
                                        <img src="assets/images/resources/testi-1-2.jpg" alt="Alesha Brown">
                                        <h3 class="testimonials-card__name">
                                            Alesha Brown
                                        </h3><!-- /.testimonials-card__name -->
                                        <p class="testimonials-card__designation">Co Founder</p><!-- /.testimonials-card__designation -->
                                    </div><!-- /.testimonials-card__image -->
                                    <div class="testimonials-card__bottom-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-2.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__bottom-bg-hover" style="background-image: url(assets/images/shapes/testi-card-bg-1-2-hover.png);"></div><!-- /.testimonials-card__top-bg -->
                                </div><!-- /.testimonials-card -->
                            </div><!-- /.item -->
                            <div class="item">
                                <div class="testimonials-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='200ms'>
                                    <div class="testimonials-card__top-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-1.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div><!-- /.testimonials-card__rating -->
                                    <div class="testimonials-card__content">
                                        Lorem ipsum is simply free dolor not sit amet, notted adipisicing elit sed do eiusmod incididunt labore et dolore text.
                                    </div><!-- /.testimonials-card__content -->
                                    <div class="testimonials-card__author">
                                        <img src="assets/images/resources/testi-1-3.jpg" alt="Kevin Martin">
                                        <h3 class="testimonials-card__name">
                                            Kevin Martin
                                        </h3><!-- /.testimonials-card__name -->
                                        <p class="testimonials-card__designation">Developer</p><!-- /.testimonials-card__designation -->
                                    </div><!-- /.testimonials-card__image -->
                                    <div class="testimonials-card__bottom-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-2.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__bottom-bg-hover" style="background-image: url(assets/images/shapes/testi-card-bg-1-2-hover.png);"></div><!-- /.testimonials-card__top-bg -->
                                </div><!-- /.testimonials-card -->
                            </div><!-- /.item -->
                            <div class="item">
                                <div class="testimonials-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='300ms'>
                                    <div class="testimonials-card__top-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-1.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div><!-- /.testimonials-card__rating -->
                                    <div class="testimonials-card__content">
                                        Lorem ipsum is simply free dolor not sit amet, notted adipisicing elit sed do eiusmod incididunt labore et dolore text.
                                    </div><!-- /.testimonials-card__content -->
                                    <div class="testimonials-card__author">
                                        <img src="assets/images/resources/testi-1-4.jpg" alt="Mark Smith">
                                        <h3 class="testimonials-card__name">
                                            Mark Smith
                                        </h3><!-- /.testimonials-card__name -->
                                        <p class="testimonials-card__designation">Reviwer</p><!-- /.testimonials-card__designation -->
                                    </div><!-- /.testimonials-card__image -->
                                    <div class="testimonials-card__bottom-bg" style="background-image: url(assets/images/shapes/testi-card-bg-1-2.png);"></div><!-- /.testimonials-card__top-bg -->
                                    <div class="testimonials-card__bottom-bg-hover" style="background-image: url(assets/images/shapes/testi-card-bg-1-2-hover.png);"></div><!-- /.testimonials-card__top-bg -->
                                </div><!-- /.testimonials-card -->
                            </div><!-- /.item -->
                        </div><!-- /.testimonials-one__carousel -->
                    </div>
                </div>
            </div><!-- /.container -->
        </section><!-- /.testimonials-one -->
        

        <section class="cta-one">
            <div class="cta-one__bg jarallax" data-jarallax data-speed="0.3" data-imgPosition="50% -100%" style="background-image: url(assets/images/backgrounds/cta-bg-1-1.jpg);"></div><!-- /.cta-one__bg -->
            <div class="cta-one__overlay-one wow slideInUp" data-wow-delay="100ms" style="background-image: url(assets/images/shapes/cta-1-overlay.png);"></div><!-- /.cta-one__overlay -->
            <div class="cta-one__overlay-two wow slideInUp" data-wow-delay="200ms" style="background-image: url(assets/images/shapes/cta-2-overlay.png);"></div><!-- /.cta-one__overlay -->
            <div class="container">
                <div class="cta-one__content text-center wow fadeInUp" data-wow-delay="400ms">
                    <h5 class="cta-one__sub-title">Weekend Special</h5><!-- /.cta-one__sub-title -->
                    <h3 class="cta-one__title">Get Up To 30% Off on Booking</h3><!-- /.cta-one__title -->
                    <a href="contact.html" class="villoz-btn">
                        <i>Start Booking</i>
                        <span>Start Booking</span>
                    </a><!-- /.cta-one__btn -->
                </div><!-- /.cta-one__content -->
            </div><!-- /.container -->
        </section><!-- /.cta-one -->
        <?php include('views/view.footer.php'); ?>


    </div><!-- /.page-wrapper -->
    
    <?php include('views/view.script.php'); ?>

    
</body>


</html>