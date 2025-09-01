<?php 
if (isset($_GET['action']) && $_GET['action'] === 'export') {
    include "../app/main.php";
    $conn = db_connect();
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="revenue_by_package_' . date('Y-m-d_His') . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Package Name', 'Payment Status', 'Total Bookings', 'Total Guests', 'Total Revenue']);
    $query = "
        SELECT 
            p.package_name,
            br.payment_status,
            COUNT(br.booking_id) AS total_bookings,
            SUM(br.guests) AS total_guests,
            SUM(p.package_amount) AS total_revenue
        FROM bookings_rooms br
        JOIN packages p ON br.package_id = p.package_id
        GROUP BY p.package_name, br.payment_status
        ORDER BY total_revenue DESC
    ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, [
            $row['package_name'],
            $row['payment_status'],
            $row['total_bookings'],
            $row['total_guests'],
            $row['total_revenue']
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
        p.package_name,
        br.payment_status,
        COUNT(br.booking_id) AS total_bookings,
        SUM(br.guests) AS total_guests,
        SUM(p.package_amount) AS total_revenue
    FROM bookings_rooms br
    JOIN packages p ON br.package_id = p.package_id
    GROUP BY p.package_name, br.payment_status
    ORDER BY total_revenue DESC
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
                        <h3 class="card-title mb-0">Revenue by Package Report</h3>
                        <a href="?action=export" class="btn btn-light btn-sm"><i class="bi bi-download me-1"></i> Export to Excel</a>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">Package Name</th>
                                        <th class="text-center">Payment Status</th>
                                        <th class="text-center">Total Bookings</th>
                                        <th class="text-center">Total Guests</th>
                                        <th class="text-center">Total Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlspecialchars($row['package_name']); ?></td>
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
                                        <td class="text-center">LKR <?php echo number_format($row['total_revenue'], 2); ?></td>
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