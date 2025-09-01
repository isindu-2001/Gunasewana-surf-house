<?php 
if (isset($_GET['action']) && $_GET['action'] === 'export') {
    include "../app/main.php";
    $conn = db_connect();
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="event_popularity_' . date('Y-m-d_His') . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Event Name', 'Total Bookings', 'Total Guests', 'Payment Status', 'Earliest Check-in']);
    $query = "
        SELECT 
            e.event_name,
            COUNT(bg.booking_id) AS total_bookings,
            SUM(bg.guests) AS total_guests,
            bg.payment_status,
            MIN(bg.checkin) AS earliest_checkin
        FROM bookings_garden bg
        JOIN events e ON bg.event_id = e.event_id
        GROUP BY e.event_name, bg.payment_status
        ORDER BY total_bookings DESC
    ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, [
            $row['event_name'],
            $row['total_bookings'],
            $row['total_guests'],
            $row['payment_status'],
            $row['earliest_checkin'] ? date('Y-m-d', strtotime($row['earliest_checkin'])) : ''
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
        e.event_name,
        COUNT(bg.booking_id) AS total_bookings,
        SUM(bg.guests) AS total_guests,
        bg.payment_status,
        MIN(bg.checkin) AS earliest_checkin
    FROM bookings_garden bg
    JOIN events e ON bg.event_id = e.event_id
    GROUP BY e.event_name, bg.payment_status
    ORDER BY total_bookings DESC
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
                        <h3 class="card-title mb-0">Event Popularity Report</h3>
                        <a href="?action=export" class="btn btn-light btn-sm"><i class="bi bi-download me-1"></i> Export to Excel</a>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">Event Name</th>
                                        <th class="text-center">Total Bookings</th>
                                        <th class="text-center">Total Guests</th>
                                        <th class="text-center">Payment Status</th>
                                        <th class="text-center">Earliest Check-in</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlspecialchars($row['event_name']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['total_bookings']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['total_guests']); ?></td>
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
                                        <td class="text-center"><?php echo $row['earliest_checkin'] ? date('d M Y', strtotime($row['earliest_checkin'])) : '-'; ?></td>
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