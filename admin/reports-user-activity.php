<?php 
if (isset($_GET['action']) && $_GET['action'] === 'export') {
    include "../app/main.php";
    $conn = db_connect();
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="user_booking_activity_' . date('Y-m-d_His') . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['User ID', 'User Name', 'Email', 'Room Bookings', 'Garden Bookings', 'Last Booking Date']);
    $query = "
        SELECT 
            u.user_id,
            CONCAT(u.user_firstName, ' ', u.user_lastName) AS user_name,
            u.user_email,
            COUNT(DISTINCT br.booking_id) AS room_bookings,
            COUNT(DISTINCT bg.booking_id) AS garden_bookings,
            MAX(COALESCE(br.bookedOn, bg.bookingOn)) AS last_booking_date
        FROM users u
        LEFT JOIN bookings_rooms br ON u.user_id = br.user_id
        LEFT JOIN bookings_garden bg ON u.user_id = bg.user_id
        GROUP BY u.user_id, u.user_firstName, u.user_lastName, u.user_email
        HAVING room_bookings > 0 OR garden_bookings > 0
        ORDER BY last_booking_date DESC
    ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, [
            $row['user_id'],
            $row['user_name'],
            $row['user_email'],
            $row['room_bookings'],
            $row['garden_bookings'],
            $row['last_booking_date'] ? date('Y-m-d H:i:s', strtotime($row['last_booking_date'])) : ''
        ]);
    }
    fclose($output);
    mysqli_free_result($result);
    mysqli_close($conn);
    exit;
} else {
    include "layouts/layout.head.php";
    $conn = db_connect();
}
$query = "
    SELECT 
        u.user_id,
        CONCAT(u.user_firstName, ' ', u.user_lastName) AS user_name,
        u.user_email,
        COUNT(DISTINCT br.booking_id) AS room_bookings,
        COUNT(DISTINCT bg.booking_id) AS garden_bookings,
        MAX(COALESCE(br.bookedOn, bg.bookingOn)) AS last_booking_date
    FROM users u
    LEFT JOIN bookings_rooms br ON u.user_id = br.user_id
    LEFT JOIN bookings_garden bg ON u.user_id = bg.user_id
    GROUP BY u.user_id, u.user_firstName, u.user_lastName, u.user_email
    HAVING room_bookings > 0 OR garden_bookings > 0
    ORDER BY last_booking_date DESC
";
$result = mysqli_query($conn, $query);
?>
<body>
    <?php include "layouts/layout.navbar.php"; ?>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">User Booking Activity Report</h3>
                        <a href="?action=export" class="btn btn-light btn-sm"><i class="bi bi-download me-1"></i> Export to Excel</a>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">User ID</th>
                                        <th class="text-center">User Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Room Bookings</th>
                                        <th class="text-center">Garden Bookings</th>
                                        <th class="text-center">Last Booking Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlspecialchars($row['user_id']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['user_name']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['user_email']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['room_bookings']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['garden_bookings']); ?></td>
                                        <td class="text-center"><?php echo $row['last_booking_date'] ? date('d M Y H:i', strtotime($row['last_booking_date'])) : '-'; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
    mysqli_free_result($result);
    mysqli_close($conn);
    include "layouts/layout.js.php"; 
    ?>
</body>
</html>