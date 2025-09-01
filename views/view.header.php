<header class="main-header__bottom sticky-header sticky-header--normal">
    <div class="container-fluid">
        <div class="main-header__logo">
            <a href="index.php">
                <img src="assets/images/logo-light.png" alt="Logo" width="125">
            </a>
        </div>
        <nav class="main-header__nav main-menu">
            <ul class="main-menu__list">
                <li><a href="index.php">Home</a></li>
                <li><a href="">About Us</a></li>
                <li><a href="book-garden.php">Garden Plans</a></li>
                <li><a href="bookings-calender.php">Bookings Calender</a></li>
                <?php if($users->isLogged()) { ?><li><a href="my-room-bookings.php">My Bookings</a></li> <?php } ?>
                <?php if($users->isLogged()) { ?><li><a href="my-garden-bookings.php">My Garden Bookings</a></li> <?php } ?>
            </ul>
        </nav>
        <div class="main-header__right">
            <div class="mobile-nav__btn mobile-nav__toggler">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <?php if(!$users->isLogged()) { ?>
                <a href="login.php" class="villoz-btn villoz-btn--border main-header__btn">
                    <i>Start Booking</i>
                    <span>Start Booking</span>
                </a>
            <?php } else {?> 
                <a href="rent-items.php" class="villoz-btn villoz-btn--border main-header__btn">
                    <i>Rent Items</i>
                    <span>Rent Items</span>
                </a>
            <?php } ?>
        </div>
    </div>
</header>
