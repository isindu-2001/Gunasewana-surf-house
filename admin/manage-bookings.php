<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    include "../app/main.php";
    $conn = db_connect();
    header('Content-Type: application/json');
    $booking_id = intval($_POST['booking_id']);
    
    // Handle booking status update
    if (isset($_POST['booking_status'])) {
        $booking_status = $_POST['booking_status'];
        
        if ($booking_id <= 0 || !in_array($booking_status, ['confirmed', 'pending', 'cancelled'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
            exit;
        }
        
        $query = "UPDATE `bookings_rooms` SET `booking_status` = ? WHERE `booking_id` = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'si', $booking_status, $booking_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Booking status updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed: ' . mysqli_error($conn)]);
        }
        
        mysqli_stmt_close($stmt);
    }
    
    // Handle booking deletion
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $query = "DELETE FROM `bookings_rooms` WHERE `booking_id` = ? AND `booking_status` = 'cancelled'";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $booking_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Booking deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database deletion failed: ' . mysqli_error($conn)]);
        }
        
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($conn);
    exit;
}

include "layouts/layout.head.php"; 

$conn = db_connect();
$query = "SELECT `booking_id`, `user_id`, `package_id`, `checkin`, `checkout`, `guests`, `booking_status`, `payment_status`, `bookedOn` FROM `bookings_rooms` WHERE 1";
$result = mysqli_query($conn, $query);
?>
<body>
    <?php include "layouts/layout.navbar.php"; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Room Bookings Management</h2>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Booking ID</th>
                                <th scope="col">User</th>
                                <th scope="col">Package</th>
                                <th scope="col">Check-in</th>
                                <th scope="col">Check-out</th>
                                <th scope="col">Guests</th>
                                <th scope="col">Booking Status</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Booked On</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            while($row = mysqli_fetch_assoc($result)) { 
                                $package = $packages->getPackage($row['package_id']);
                                $user = $users->getUser($row['user_id']);
                                ?>
                            <tr>
                                <th scope="row"><?=$row['booking_id']?></th>
                                <td><?=$user['user_firstName']?> <?=$user['user_lastName']?></td>
                                <td><?=$package['package_name']?></td>
                                <td><?=date('d M Y', strtotime($row['checkin']))?></td>
                                <td><?=date('d M Y', strtotime($row['checkout']))?></td>
                                <td><?=$row['guests']?></td>
                                <td>
                                    <?php
                                    $booking_status = $row['booking_status'];
                                    $badge_class = match($booking_status) {
                                        'confirmed' => 'bg-success',
                                        'pending' => 'bg-warning',
                                        'cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?=$badge_class?>"><?=$booking_status?></span>
                                </td>
                                <td>
                                    <?php
                                    $payment_status = $row['payment_status'];
                                    $payment_badge = match($payment_status) {
                                        'paid' => 'bg-success',
                                        'pending' => 'bg-warning',
                                        'failed' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?=$payment_badge?>"><?=$payment_status?></span>
                                </td>
                                <td><?=date('d M Y H:i', strtotime($row['bookedOn']))?></td>
                                <td>
                                    <?php if ($booking_status === 'cancelled'): ?>
                                        <button class="btn btn-danger btn-sm delete-booking" data-booking-id="<?=$row['booking_id']?>">Delete</button>
                                    <?php else: ?>
                                        <select class="form-select booking-status" data-booking-id="<?=$row['booking_id']?>" style="width: 120px;">
                                            <option value="confirmed" <?=$booking_status == 'confirmed' ? 'selected' : ''?>>Confirmed</option>
                                            <option value="pending" <?=$booking_status == 'pending' ? 'selected' : ''?>>Pending</option>
                                            <option value="cancelled" <?=$booking_status == 'cancelled' ? 'selected' : ''?>>Cancelled</option>
                                        </select>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php 
    mysqli_free_result($result);
    mysqli_close($conn);
    include "layouts/layout.js.php"; 
    ?>

    <script>
    $(document).ready(function() {
        // Booking status update
        $('.booking-status').on('change', function() {
            const bookingId = $(this).data('booking-id');
            const newStatus = $(this).val();
            const $badge = $(this).closest('tr').find('.badge').eq(0); 

            $.ajax({
                url: window.location.href,
                method: 'POST',
                data: {
                    booking_id: bookingId,
                    booking_status: newStatus
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $badge.removeClass('bg-success bg-warning bg-danger bg-secondary');
                        const badgeClass = newStatus === 'confirmed' ? 'bg-success' :
                                        newStatus === 'pending' ? 'bg-warning' :
                                        newStatus === 'cancelled' ? 'bg-danger' : 'bg-secondary';
                        $badge.addClass(badgeClass).text(newStatus);
                        alert(response.message || 'Booking status updated successfully');
                    } else {
                        console.error('Update failed:', response.message);
                        alert('Error: ' + (response.message || 'Unknown error'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Failed to update booking status: ' + error);
                }
            });
        });

        // Booking deletion
        $('.delete-booking').on('click', function() {
            const bookingId = $(this).data('booking-id');
            const $row = $(this).closest('tr');
            
            if (confirm('Are you sure you want to delete this booking?')) {
                $.ajax({
                    url: window.location.href,
                    method: 'POST',
                    data: {
                        booking_id: bookingId,
                        action: 'delete'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $row.remove();
                            alert(response.message || 'Booking deleted successfully');
                        } else {
                            console.error('Deletion failed:', response.message);
                            alert('Error: ' + (response.message || 'Unknown error'));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        alert('Failed to delete booking: ' + error);
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
