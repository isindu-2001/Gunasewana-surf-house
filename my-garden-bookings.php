<?php 
include('views/view.head.php'); 

if (isset($_GET['action']) && $_GET['action'] == 'cancel' && isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];
    $bookings->cancelGardenBooking($booking_id);
    redirect('my-room-bookings.php?error=Booking cancelled&type=success');
    exit;
}
?>

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

        
        <section class="page-header">
            <div class="page-header__bg"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <ul class="villoz-breadcrumb list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li><span>My Bookings</span></li>
                </ul><!-- /.thm-breadcrumb list-unstyled -->
                <h2 class="page-header__title">My Garden Bookings</h2>
            </div><!-- /.container -->
        </section><!-- /.page-header -->


        <!-- Cart Start -->
        <section class="cart-page">
            <div class="container">
                <div class="table-responsive">
                    <table class="table cart-page__table">
                        <thead>
                            <tr>
                                <th>Package</th>
                                <th>Checkin</th>
                                <th>Checkout</th>
                                <th>Guests</th>
                                <th>Booking Status</th>
                                <th>Payment Status</th>
                                <th>Booked On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $myBookings = $bookings->fetchMyGardenBookings();

                            foreach ($myBookings as $booking) {
                                $event = events::getEvent($booking['event_id']);
                                $event = (object) $event;

                                echo '<tr>
                                    <td>'.$event->event_name.'</td>
                                    <td>'.$booking['checkin'].'</td>
                                    <td>'.$booking['checkout'].'</td>
                                    <td>'.$booking['guests'].'</td>
                                    <td>'.$booking['booking_status'].'</td>
                                    <td>'.$booking['payment_status'].'</td>
                                    <td>'.$booking['bookingOn'].'</td>
                                    <td>';
                                    if ($booking['booking_status'] == 'pending') {
                                        echo '<a href="?action=cancel&booking_id='.$booking['booking_id'].'" class="btn btn-danger btn-sm">Cancel</a>';
                                    }
                                    echo '</td>
                                </tr>';
                            }
                            ?>
                            
                        </tbody>
                    </table>
                </div>
                
            </div>
        </section>

        <?php include('views/view.footer.php'); ?>


    </div><!-- /.page-wrapper -->
    
    <?php include('views/view.script.php'); ?>

    
</body>


</html>