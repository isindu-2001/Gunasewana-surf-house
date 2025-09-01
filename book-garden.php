<?php 
include('views/view.head.php'); 

if(isset($_POST['action'])){
    
    $event = postData('event');
    $checkin = postData('checkin');
    $checkout = postData('checkout');
    $guests = postData('guests');

    if (strtotime($checkout) < strtotime($checkin)) {
        redirect('index.php?error=Checkout date cannot be earlier than check-in date&type=error');
        exit;
    }

    $event = events::getEvent($event);
    if(!$event) {
        redirect('index.php?error=Event not found&type=error');
        exit;
    }

    $conn = db_connect();
    $query = "SELECT `booking_id`, `user_id`, `event_id`, `checkin`, `checkout`, `guests`, `booking_status`, `payment_status`, `bookingOn` FROM `bookings_garden` WHERE (`checkin` BETWEEN '$checkin' AND '$checkout') OR (`checkout` BETWEEN '$checkin' AND '$checkout')";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        redirect('index.php?error=Booking already exists for the given date period&type=error');
        exit;
    }

    $isDone = false;
    $query = "INSERT INTO `bookings_garden` (`user_id`, `event_id`, `checkin`, `checkout`, `guests`) VALUES ('".$_SESSION['user_id']."', '".$event['event_id']."', '".$checkin."', '".$checkout."', '".$guests."')";
    if (mysqli_query($conn, $query)) {
        $isDone = true;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    if(!$isDone) {
        redirect('index.php?error=Something went wrong&type=error');
        exit;
    }

    $total = 3000 * $guests;
    $merchant_id = "1220939";
    $merchant_secret = "NDE1NjM5NDE4NTUwMDI2MDMyOTE4OTIxNzUwNTUxMjk2MzQ0NjIx";
    $order_id = "ItemNo" . $event['event_id'];
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
            <input type="text" name="items" value="<?php echo $event['event_name']; ?>">
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

        <section class="page-header page-header--blank">
            <div class="page-header__bg"></div>
        </section>

        <section class="villa-details-gallery">
            <div class="villa-details-gallery__carousel villoz-owl__carousel owl-carousel owl-theme" data-owl-options='{
        "items": 4,
        "margin": 10,
        "loop": true,
        "smartSpeed": 700,
        "autoWidth": true,
        "autoplayTimeout": 6000, 
        "nav": true,
        "navText": ["<span class=\"icon-left-arrow\"></span>","<span class=\"icon-right-arrow\"></span>"],
        "dots": false,
        "autoplay": true,
        "responsive": {
            "0": {
                "items": 1
            },
            "575": {
                "items": 2
            },
            "768": {
                "items": 3
            },
            "992": {
                "items": 4
            }
        }
        }'>
                <div class="item">
                    <div class="villa-details-gallery__item"><img src="assets/images/villa/villa-d-1-1.jpg" alt="villoz"></div>
                </div>
                <div class="item">
                    <div class="villa-details-gallery__item"><img src="assets/images/villa/villa-d-1-2.jpg" alt="villoz"></div>
                </div>
                <div class="item">
                    <div class="villa-details-gallery__item"><img src="assets/images/villa/villa-d-1-3.jpg" alt="villoz"></div>
                </div>
                <div class="item">
                    <div class="villa-details-gallery__item"><img src="assets/images/villa/villa-d-1-4.jpg" alt="villoz"></div>
                </div>
                <div class="item">
                    <div class="villa-details-gallery__item"><img src="assets/images/villa/villa-d-1-5.jpg" alt="villoz"></div>
                </div>
                <div class="item">
                    <div class="villa-details-gallery__item"><img src="assets/images/villa/villa-d-1-6.jpg" alt="villoz"></div>
                </div>
                <div class="item">
                    <div class="villa-details-gallery__item"><img src="assets/images/villa/villa-d-1-7.jpg" alt="villoz"></div>
                </div>
                <div class="item">
                    <div class="villa-details-gallery__item"><img src="assets/images/villa/villa-d-1-8.jpg" alt="villoz"></div>
                </div>
            </div>
            <div class="villa-details-gallery__btns">
                <a class="villoz-image-popup" href="#" data-gallery-options='{
            "items": [
              {
                "src": "assets/images/villa/villa-d-1-1.jpg"
              },
              {
                "src": "assets/images/villa/villa-d-1-2.jpg"
              },
              {
                "src": "assets/images/villa/villa-d-1-3.jpg"
              },
              {
                "src": "assets/images/villa/villa-d-1-4.jpg"
              }
            ],
            "gallery": {
              "enabled": true
            },
            "type": "image"
        }'><span class="icon-camera"></span><span class="villa-card-two__btns__count">4</span></a>
                <a class="video-popup" href="https://www.youtube.com/watch?v=0MuL8fd3pb8"><span class="icon-video"></span></a>
            </div>
        </section>

        <section class="villa-details-three">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="villa-details-sidebar">
                            <div class="villa-details-sidebar__booking">
                                <h4 class="villa-details-sidebar__booking__title">Reserve Garden</h4>
                                <form class="villa-details-sidebar__form" action="book-garden.php" method="POST">
                                    <div class="villa-details-sidebar__control">
                                        <label for="event">Event <span class="text-danger">*</span></label>
                                        <select class="form-control" id="event" name="event" required>
                                            <option value="">Select Event</option>
                                            <?php foreach($events->fetchEvents() as $event): ?>
                                            <option value="<?php echo $event['event_id']; ?>"><?php echo $event['event_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="villa-details-sidebar__control">
                                        <label for="checkin">Checkin <span class="text-danger">*</span></label>
                                        <input class="villoz-datepicker" id="checkin" type="text" name="checkin" placeholder="Select Date" required>
                                    </div>
                                    <div class="villa-details-sidebar__control">
                                        <label for="checkout">Checkout <span class="text-danger">*</span></label>
                                        <input class="villoz-datepicker" id="checkout" type="text" name="checkout" placeholder="Select Date" required>
                                    </div>
                                    <div class="villa-details-sidebar__control">
                                        <label for="guests">Guests <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="guests" id="guests" value="0" min="0" required>
                                    </div>
                                    <input type="hidden" name="action" value="book">
                                    <button type="submit" class="villoz-btn">
                                        <i>Book Now</i>
                                        <span>Book Now</span>
                                    </button>
                                </form>
                            </div>
                            
                            
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
