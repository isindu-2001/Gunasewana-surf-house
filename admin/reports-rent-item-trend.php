<?php 


if (isset($_GET['action']) && $_GET['action'] === 'export') {
    include "../app/main.php";
    $conn = db_connect();
   
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="rent_item_request_trends_' . date('Y-m-d_His') . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Item Name', 'Status', 'Total Requests', 'Total Revenue', 'Last Request Date']);
    $query = "
        SELECT 
            ri.item_name,
            rr.status,
            COUNT(rr.request_id) AS total_requests,
            SUM(ri.item_fee) AS total_revenue,
            MAX(rr.rentedOn) AS last_request_date
        FROM rent_requests rr
        JOIN rent_items ri ON rr.item_id = ri.item_id
        GROUP BY ri.item_name, rr.status
        ORDER BY total_requests DESC, ri.item_name
    ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, [
            $row['item_name'],
            $row['status'],
            $row['total_requests'],
            number_format($row['total_revenue'], 2),
            $row['last_request_date'] ? date('Y-m-d H:i:s', strtotime($row['last_request_date'])) : ''
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
        ri.item_name,
        rr.status,
        COUNT(rr.request_id) AS total_requests,
        SUM(ri.item_fee) AS total_revenue,
        MAX(rr.rentedOn) AS last_request_date
    FROM rent_requests rr
    JOIN rent_items ri ON rr.item_id = ri.item_id
    GROUP BY ri.item_name, rr.status
    ORDER BY total_requests DESC, ri.item_name
";
$result = mysqli_query($conn, $query);
$chart_query = "
    SELECT 
        DATE_FORMAT(rentedOn, '%Y-%m') AS month,
        COUNT(request_id) AS total_requests
    FROM rent_requests
    GROUP BY DATE_FORMAT(rentedOn, '%Y-%m')
    ORDER BY month
";
$chart_result = mysqli_query($conn, $chart_query);
$chart_data = [];
while ($row = mysqli_fetch_assoc($chart_result)) {
    $chart_data[] = [
        'month' => $row['month'],
        'total_requests' => $row['total_requests']
    ];
}
$chart_labels = array_column($chart_data, 'month');
$chart_values = array_column($chart_data, 'total_requests');
?>
<body>
    <?php include "layouts/layout.navbar.php"; ?>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow-lg border-0 mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Rent Item Request Trends Report</h3>
                        <a href="?action=export" class="btn btn-light btn-sm"><i class="bi bi-download me-1"></i> Export to Excel</a>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">Item Name</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Total Requests</th>
                                        <th class="text-center">Total Revenue</th>
                                        <th class="text-center">Last Request Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlspecialchars($row['item_name']); ?></td>
                                        <td class="text-center">
                                            <?php
                                            $status = $row['status'];
                                            $badge_class = match($status) {
                                                'approved' => 'bg-success',
                                                'pending' => 'bg-warning',
                                                'rejected' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                            ?>
                                            <span class="badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($status); ?></span>
                                        </td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['total_requests']); ?></td>
                                        <td class="text-center">LKR <?php echo number_format($row['total_revenue'], 2); ?></td>
                                        <td class="text-center"><?php echo $row['last_request_date'] ? date('d M Y H:i', strtotime($row['last_request_date'])) : '-'; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Monthly Request Growth</h3>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="requestGrowthChart" style="max-height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
    mysqli_free_result($result);
    mysqli_free_result($chart_result);
    mysqli_close($conn);
    include "layouts/layout.js.php"; 
    ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('requestGrowthChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($chart_labels); ?>,
                datasets: [{
                    label: 'Total Requests',
                    data: <?php echo json_encode($chart_values); ?>,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Monthly Rent Item Request Trends' }
                },
                scales: {
                    x: { title: { display: true, text: 'Month' } },
                    y: { title: { display: true, text: 'Number of Requests' }, beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>