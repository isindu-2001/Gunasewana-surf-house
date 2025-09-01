<?php 
if (isset($_GET['action']) && $_GET['action'] === 'export') {
    include "../app/main.php";
    $conn = db_connect();
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="booking_summary_' . date('Y-m-d_His') . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Booking Type', 'Booking Status', 'Payment Status', 'Total Bookings', 'Total Guests']);
    $query = "
        SELECT 
            'Room' AS booking_type,
            br.booking_status,
            br.payment_status,
            COUNT(*) AS total_bookings,
            SUM(br.guests) AS total_guests
        FROM bookings_rooms br
        GROUP BY br.booking_status, br.payment_status
        UNION ALL
        SELECT 
            'Garden' AS booking_type,
            bg.booking_status,
            bg.payment_status,
            COUNT(*) AS total_bookings,
            SUM(bg.guests) AS total_guests
        FROM bookings_garden bg
        GROUP BY bg.booking_status, bg.payment_status
        ORDER BY booking_type, booking_status, payment_status
    ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, [
            $row['booking_type'],
            $row['booking_status'],
            $row['payment_status'],
            $row['total_bookings'],
            $row['total_guests']
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
        'Room' AS booking_type,
        br.booking_status,
        br.payment_status,
        COUNT(*) AS total_bookings,
        SUM(br.guests) AS total_guests
    FROM bookings_rooms br
    GROUP BY br.booking_status, br.payment_status
    UNION ALL
    SELECT 
        'Garden' AS booking_type,
        bg.booking_status,
        bg.payment_status,
        COUNT(*) AS total_bookings,
        SUM(bg.guests) AS total_guests
    FROM bookings_garden bg
    GROUP BY bg.booking_status, bg.payment_status
    ORDER BY booking_type, booking_status, payment_status
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
                        <h3 class="card-title mb-0">Booking Summary Report</h3>
                        <a href="?action=export" class="btn btn-light btn-sm"><i class="bi bi-download me-1"></i> Export to Excel</a>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">Booking Type</th>
                                        <th class="text-center">Booking Status</th>
                                        <th class="text-center">Payment Status</th>
                                        <th class="text-center">Total Bookings</th>
                                        <th class="text-center">Total Guests</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlspecialchars($row['booking_type']); ?></td>
                                        <td class="text-center">
                                            <?php
                                            $booking_status = $row['booking_status'];
                                            $badge_class = match($booking_status) {
                                                'confirmed' => 'bg-success',
                                                'pending' => 'bg-warning',
                                                'cancelled' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                            ?>
                                            <span class="badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($booking_status); ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $payment_status = $row['payment_status'];
                                            $payment_badge = match($payment_status) {
                                                'paid' => 'bg-success',
                                                'pending' => 'bg-warning',
                                                'failed' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                            ?>
                                            <span class="badge <?php echo $payment_badge; ?>"><?php echo htmlspecialchars($payment_status); ?></span>
                                        </td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['total_bookings']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['total_guests']); ?></td>
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