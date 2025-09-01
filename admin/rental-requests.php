<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'])) {
    include "../app/main.php";
    $conn = db_connect();
    header('Content-Type: application/json');
    $request_id = intval($_POST['request_id']);
    
    // Handle status update
    if (isset($_POST['status'])) {
        $status = $_POST['status'];
        
        if ($request_id <= 0 || !in_array($status, ['confirmed', 'pending', 'cancelled'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
            exit;
        }
        
        $query = "UPDATE `rent_requests` SET `status` = ? WHERE `request_id` = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'si', $status, $request_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Rental status updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed: ' . mysqli_error($conn)]);
        }
        
        mysqli_stmt_close($stmt);
    }
    
    // Handle rental request deletion
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $query = "DELETE FROM `rent_requests` WHERE `request_id` = ? AND `status` = 'cancelled'";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $request_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Rental request deleted successfully']);
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
$query = "SELECT `request_id`, `user_id`, `item_id`, `hours`, `total`, `status`, `rentedOn` FROM `rent_requests` WHERE 1";
$result = mysqli_query($conn, $query);
?>
<body>
    <?php include "layouts/layout.navbar.php"; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Rental Requests Management</h2>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Request ID</th>
                                <th scope="col">User</th>
                                <th scope="col">Item</th>
                                <th scope="col">Hours</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                                <th scope="col">Rented On</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            while($row = mysqli_fetch_assoc($result)) { 
                                $item = $rents->getItem($row['item_id']);
                                $user = $users->getUser($row['user_id']);
                                ?>
                            <tr>
                                <th scope="row"><?=$row['request_id']?></th>
                                <td><?=$user['user_firstName']?> <?=$user['user_lastName']?></td>
                                <td><?=$item['item_name']?></td>
                                <td><?=$row['hours']?></td>
                                <td>LKR <?=$row['total']?></td>
                                <td>
                                    <?php
                                    $status = $row['status'];
                                    $badge_class = match($status) {
                                        'confirmed' => 'bg-success',
                                        'pending' => 'bg-warning',
                                        'cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?=$badge_class?>"><?=$status?></span>
                                </td>
                                <td><?=date('d M Y H:i', strtotime($row['rentedOn']))?></td>
                                <td>
                                    <?php if ($status === 'cancelled'): ?>
                                        <button class="btn btn-danger btn-sm delete-request" data-request-id="<?=$row['request_id']?>">Delete</button>
                                    <?php else: ?>
                                        <select class="form-select rental-status" data-request-id="<?=$row['request_id']?>" style="width: 120px;">
                                            <option value="confirmed" <?=$status == 'confirmed' ? 'selected' : ''?>>Confirmed</option>
                                            <option value="pending" <?=$status == 'pending' ? 'selected' : ''?>>Pending</option>
                                            <option value="cancelled" <?=$status == 'cancelled' ? 'selected' : ''?>>Cancelled</option>
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
        $('.rental-status').on('change', function() {
            const requestId = $(this).data('request-id');
            const newStatus = $(this).val();
            const $badge = $(this).closest('tr').find('.badge');

            $.ajax({
                url: window.location.href,
                method: 'POST',
                data: {
                    request_id: requestId,
                    status: newStatus
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $badge.removeClass('bg-success bg-warning bg-danger bg-secondary');
                        const badgeClass = newStatus === 'confirmed' ? 'bg-success' :
                                        newStatus === 'pending' ? 'bg-warning' :
                                        newStatus === 'cancelled' ? 'bg-danger' : 'bg-secondary';
                        $badge.addClass(badgeClass).text(newStatus);
                        alert(response.message || 'Rental status updated successfully');
                        if (newStatus === 'cancelled') {
                            location.reload(); 
                        }
                    } else {
                        console.error('Update failed:', response.message);
                        alert('Error: ' + (response.message || 'Unknown error'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Failed to update rental status: ' + error);
                }
            });
        });
        
        $('.delete-request').on('click', function() {
            const requestId = $(this).data('request-id');
            const $row = $(this).closest('tr');
            
            if (confirm('Are you sure you want to delete this rental request?')) {
                $.ajax({
                    url: window.location.href,
                    method: 'POST',
                    data: {
                        request_id: requestId,
                        action: 'delete'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $row.remove();
                            alert(response.message || 'Rental request deleted successfully');
                        } else {
                            console.error('Deletion failed:', response.message);
                            alert('Error: ' + (response.message || 'Unknown error'));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        alert('Failed to delete rental request: ' + error);
                    }
                });
            }
        });
    });
    </script>
</body>
</html>