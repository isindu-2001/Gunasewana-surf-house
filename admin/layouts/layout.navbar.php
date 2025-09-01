<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Villa Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage Payments
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="manage-payments.php">Manage Payments</a></li>
                        <li><a class="dropdown-item" href="manage-payments-gardens.php">Manage Garden Booking Payments</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Booking Management
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="manage-bookings.php">Manage Bookings</a></li>
                        <li><a class="dropdown-item" href="manage-bookings-gardens.php">Manage Garden Bookings</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Reports
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="reports-booking-summary.php">Booking Summary</a></li>
                        <li><a class="dropdown-item" href="reports-revenue-by-package.php">Revenue by Package</a></li>
                        <li><a class="dropdown-item" href="reports-rent-item-trend.php">Rent Item Trend</a></li>
                        <li><a class="dropdown-item" href="reports-event-popularity.php">Event Popularity</a></li>
                        <li><a class="dropdown-item" href="reports-user-activity.php">User Activity</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="rental-requests.php">Item Rental Requests</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="manage-events.php">Manage Events</a></li>
                        <li><a class="dropdown-item" href="manage-rent-items.php">Manage Rent Items</a></li>
                    </ul>
                </li>
            </ul>
            <div class="ms-auto">
                <a href="../logout.php" class="btn btn-outline-dark btn-sm">Logout <i class="bi bi-box-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</nav>