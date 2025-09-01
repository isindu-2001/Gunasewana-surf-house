<?php 
include('views/view.head.php'); 

if (isset($_GET['action']) && $_GET['action'] == 'cancel' && isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];
    $bookings->cancelBooking($booking_id);
    redirect('my-room-bookings.php?error=Booking cancelled&type=success');
    exit;
}

// Handle booking update
if (isset($_POST['update_booking']) && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    
    // Validate dates
    if (strtotime($checkin) < strtotime($checkout)) {
        if ($bookings->updateBookingDates($booking_id, $checkin, $checkout)) {
            redirect('my-room-bookings.php?error=Booking updated successfully&type=success');
        } else {
            redirect('my-room-bookings.php?error=Booking update failed&type=error');
        }
    } else {
        redirect('my-room-bookings.php?error=Invalid dates: Check-out must be after check-in&type=error');
    }
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
                <h2 class="page-header__title">My Room Bookings</h2>
            </div><!-- /.container -->
        </section><!-- /.page-header -->

        <!-- Cart Start -->
        <section class="cart-page">
            <div class="container">
                <?php if (isset($_GET['error']) && isset($_GET['type'])): ?>
                    <div class="alert alert-<?php echo $_GET['type']; ?>">
                        <?php echo $_GET['error']; ?>
                    </div>
                <?php endif; ?>
                
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
                            $myBookings = $bookings->fetchMyBookings();

                            foreach ($myBookings as $booking) {
                                $package = packages::getPackage($booking['package_id']);
                                $package = (object) $package;

                                echo '<tr>
                                    <td>'.$package->package_name.'</td>
                                    <td>'.$booking['checkin'].'</td>
                                    <td>'.$booking['checkout'].'</td>
                                    <td>'.$booking['guests'].'</td>
                                    <td>'.$booking['booking_status'].'</td>
                                    <td>'.$booking['payment_status'].'</td>
                                    <td>'.$booking['bookedOn'].'</td>
                                    <td>';
                                    if ($booking['booking_status'] == 'pending') {
                                        echo '<a href="?action=cancel&booking_id='.$booking['booking_id'].'" class="btn btn-danger btn-sm">Cancel</a> ';
                                        echo '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editBookingModal'.$booking['booking_id'].'">Edit Dates</button>';
                                    }
                                    echo '</td>
                                </tr>';
                                
                                echo '
                                <div class="modal fade" id="editBookingModal'.$booking['booking_id'].'" tabindex="-1" aria-labelledby="editBookingModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editBookingModalLabel">Edit Booking Dates</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST" action="my-room-bookings.php">
                                                <div class="modal-body">
                                                    <input type="hidden" name="booking_id" value="'.$booking['booking_id'].'">
                                                    <div class="mb-3">
                                                        <label for="checkin" class="form-label">Check-in Date</label>
                                                        <input type="date" class="form-control" name="checkin" value="'.$booking['checkin'].'" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="checkout" class="form-label">Check-out Date</label>
                                                        <input type="date" class="form-control" name="checkout" value="'.$booking['checkout'].'" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="update_booking" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>';
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