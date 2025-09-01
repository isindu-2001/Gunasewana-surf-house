<?php include('views/view.head.php'); ?>

<body class="custom-cursor">

    <div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div>

    <div class="preloader">
        <div class="preloader__image" style="background-image: url(assets/images/loader.png);"></div>
    </div>
    <div class="page-wrapper">
        <div class="main-header">
            <?php include('views/view.topbar.php'); ?>
            <?php include('views/view.header.php'); ?>
        </div>
        <section class="page-header">
            <div class="page-header__bg"></div>
            <div class="container">
                <ul class="villoz-breadcrumb list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li><span>Login</span></li>
                </ul>
                <h2 class="page-header__title">Login</h2>
            </div>
        </section>
        <section class="login-page">
            <div class="container">
                
                <div class="row">
                    <div class="col-lg-6 wow fadeInUp animated" data-wow-delay="300ms">
                        <div class="login-page__wrap">
                            <h3 class="login-page__wrap__title">Login</h3>
                            <form method="POST" action="app/actions/action.loginUser.php" class="login-page__form">
                                <div class="login-page__form-input-box">
                                    <input type="email" name="email" placeholder="Email *">
                                </div>
                                <div class="login-page__form-input-box">
                                    <input type="password" name="password" placeholder="Password *">
                                </div>
                                <div class="login-page__checked-box">
                                    <input type="checkbox" name="save-data" id="save-data">
                                    <label for="save-data"><span></span>Remember Me?</label>
                                </div>
                                <div class="login-page__form-btn-box">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <button type="submit" class="villoz-btn">
                                        <i>Login</i>
                                        <span>Login</span>
                                    </button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInUp animated" data-wow-delay="400ms">
                        <div class="login-page__wrap">
                            <h3 class="login-page__wrap__title">Register</h3>
                            <form action="app/actions/action.registerUser.php" method="POST" class="login-page__form">
                                <div class="checkout-page__input-box">
                                    <input type="text" placeholder="First Name" name="first_name" required>
                                </div>
                                <div class="checkout-page__input-box">
                                    <input type="text" placeholder="Last Name" name="last_name" required>
                                </div>
                                <div class="checkout-page__input-box">
                                    <input type="text" pattern="[0-9]*"  placeholder="Mobile Number" name="mobile_number" required>
                                </div>
                                <div class="login-page__form-input-box">
                                    <input type="email" placeholder="Email address" name="email" required>
                                </div>
                                <div class="login-page__form-input-box">
                                    <input type="password" placeholder="Password" name="password" required>
                                </div>
                                <div class="login-page__form-input-box">
                                    <input type="password" placeholder="Confirm Password" name="confirm_password" required>
                                </div>
                                <div class="login-page__checked-box">
                                    <input type="checkbox" name="accept-policy" id="accept-policy" required>
                                    <label for="accept-policy"><span></span>I accept company privacy policy.</label>
                                </div>
                                <div class="login-page__form-btn-box">
                                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                    <button type="submit" class="villoz-btn">
                                        <i>Register</i>
                                        <span>Register</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include('views/view.footer.php'); ?>
    </div>
    <?php include('views/view.script.php'); ?>
</body>
</html>
