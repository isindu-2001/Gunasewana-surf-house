<?php 
include('views/view.head.php'); 

if(!isset($_GET['package']) || !isset($_GET['checkin']) || !isset($_GET['checkout']) || !isset($_GET['guests'])) {
    header('Location: book-room.php?package=1&checkin=08%2F01%2F2025&checkout=08%2F02%2F2025&guests=2');
    exit;
}

$package = getData('package');
$checkin = getData('checkin');
$checkout = getData('checkout');
$guests = getData('guests');

if (strtotime($checkout) < strtotime($checkin)) {
    redirect('index.php?error=Checkout date cannot be earlier than check-in date&type=error');
    exit;
}

$package = packages::getPackage($package);
if(!$package) {
    redirect('index.php?error=Package not found&type=error');
    exit;
}

$package = (object) $package;

$total = $package->package_amount * $guests;

if (isset($_GET['action']) && $_GET['action'] == 'book') {
    $user_id = $_SESSION['user_id'];
    $conn = db_connect();
    $isDone = false;
    $query = "INSERT INTO `bookings_rooms`(`user_id`, `package_id`, `checkin`, `checkout`, `guests`) VALUES ('$user_id', '$package->package_id', '$checkin', '$checkout', '$guests')";
    if (mysqli_query($conn, $query)) {
        $last_id = mysqli_insert_id($conn);
        $isDone = true;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    if(!$isDone) {
        redirect('index.php?error=Something went wrong&type=error');
        exit;
    }

    $merchant_id = "1220939";
    $merchant_secret = "NDE1NjM5NDE4NTUwMDI2MDMyOTE4OTIxNzUwNTUxMjk2MzQ0NjIx";
    $order_id = "ItemNo12345";
    $amount = $total;
    $currency = "LKR";
    $hash = strtoupper(
        md5(
            $merchant_id .
            $order_id .
            number_format($amount, 2, '.', '') .
            $currency .
            strtoupper(md5($merchant_secret))
        )
    );

    $user = $users->getUser($users->getID());
    $user = (object) $user;
?>
    <html>
    <body onload="document.forms[0].submit()">
        <form method="post" action="https://sandbox.payhere.lk/pay/checkout">
            <input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>">
            <input type="hidden" name="return_url" value="http://localhost/">
            <input type="hidden" name="cancel_url" value="http://localhost/">
            <input type="hidden" name="notify_url" value="http://localhost/">
            <input type="text" name="order_id" value="<?php echo $order_id; ?>">
            <input type="text" name="items" value="<?php echo $package->package_name; ?>">
            <input type="text" name="currency" value="<?php echo $currency; ?>">
            <input type="text" name="amount" value="<?php echo $amount; ?>">
            <input type="text" name="first_name" value="<?php echo $user->user_firstName; ?>">
            <input type="text" name="last_name" value="<?php echo $user->user_lastName; ?>">
            <input type="text" name="email" value="<?php echo $user->user_email; ?>">
            <input type="text" name="phone" value="<?php echo $user->user_phone; ?>">
            <input type="text" name="address" value="No.1, Galle Road">
            <input type="text" name="city" value="Colombo">
            <input type="hidden" name="country" value="Sri Lanka">
            <input type="hidden" name="hash" value="<?php echo $hash; ?>">
        </form>
    </body>
    </html>
<?php
    die();
}
?>

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

        <section class="page-header page-header--blank" style="background: linear-gradient(135deg, #1e3c72, #2a5298);">
            <div class="container text-center py-5">
                <h1 class="text-white display-4 fw-bold">Book Your Villa</h1>
                <p class="text-white lead">Experience luxury and comfort with <?php echo htmlspecialchars($package->package_name); ?></p>
            </div>
        </section>

        <section class="villa-details-one py-5 bg-light">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h3 class="card-title mb-3"><?php echo htmlspecialchars($package->package_name); ?></h3>
                                <p class="text-muted mb-4">You have selected this exclusive package for your stay.</p>
                                <div class="d-flex justify-content-between align-items-center bg-primary text-white p-3 rounded">
                                    <span class="fw-bold">Price per Guest</span>
                                    <span class="fs-5">LKR <?php echo number_format($package->package_amount, 2); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h4 class="card-title mb-4">Booking Details</h4>
                                <form class="villa-details-sidebar__form contact-form-validated">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="checkin" class="form-label">Check-in Date</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                <input id="checkin" type="text" class="form-control" name="checkin" value="<?php echo htmlspecialchars($checkin); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="checkout" class="form-label">Check-out Date</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                <input id="checkout" type="text" class="form-control" name="checkout" value="<?php echo htmlspecialchars($checkout); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="guests" class="form-label">Guests</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-users"></i></span>
                                                <input type="number" class="form-control" name="guests" id="guests" value="<?php echo htmlspecialchars($guests); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-end">
                                            <div class="w-100 bg-success text-white p-3 rounded text-center">
                                                <span class="fw-bold">Total</span>
                                                <h3 class="mb-0 text-white">LKR <?php echo number_format($total, 2); ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="villa-details-three py-5">
            <div class="container">
                <h2 class="text-center mb-5 fw-bold">Your Order Summary</h2>
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-end">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo htmlspecialchars($package->package_name); ?></td>
                                            <td class="text-end">LKR <?php echo number_format($package->package_amount, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Number of Guests</td>
                                            <td class="text-end"><?php echo htmlspecialchars($guests); ?></td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td>Total</td>
                                            <td class="text-end">LKR <?php echo number_format($total, 2); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h4 class="mb-4">Payment Method</h4>
                                <div class="checkout-page__payment__item bg-primary text-white p-3 rounded mb-3">
                                    <h5 class="mb-0 text-white"><i class="fas fa-credit-card me-2 text-white"></i>Credit / Debit Card</h5>
                                </div>
                                <p class="text-muted">Secure payment processing via PayHere. Please use your Order ID as the payment reference.</p>
                                <div class="text-end mt-4">
                                    <a href="<?php echo $SITE_URL_SELF; ?>&action=book" class="btn btn-primary btn-lg">
                                        <i class="fas fa-check-circle me-2"></i>Place Your Order
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include('views/section.calender.php'); ?>
        <?php include('views/view.footer.php'); ?>
    </div>

    <?php include('views/view.script.php'); ?>
</body>
</html>