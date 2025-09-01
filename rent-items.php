<?php 
include('views/view.head.php'); 

$items = $rents->fetchItems();
$item_fees = [];
foreach ($items as $item) {
    $item_fees[$item['item_id']] = $item['item_fee'];
}

if (isset($_POST['action']) && $_POST['action'] === 'request') {
    $item_id = postData('event');
    $hours = postData('hours');
    $total_cost = isset($item_fees[$item_id]) ? $item_fees[$item_id] * $hours : 0;
    
    $db = db();

    $stmt = $db->prepare("INSERT INTO `rent_requests`(`user_id`, `item_id`, `hours`, `total`, `status`) VALUES (:user_id, :item_id, :hours, :total, :status)");
    if ($stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'item_id' => $item_id,
        'hours' => $hours,
        'total' => $total_cost,
        'status' => 'pending'
    ])) {
        redirect('rent-items-history.php?error=Item Successfully Added&type=success');
    } else {
        redirect('rent-items.php?error=Error Adding Item&type=error');
    }
    
}
?>

<body class="custom-cursor">
    <div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div>

    <div class="preloader">
        <div class="preloader__image" style="background-image: url(assets/images/loader.png);"></div>
    </div>
    <div class="page-wrapper">
        <div class="main-header">
            <?php include('views/view.topbar.php'); ?>
            <?php include('views/view.header.php'); ?>
        </div>

        <section class="page-header page-header--blank">
            <div class="page-header__bg"></div>
        </section>

        <section class="villa-details-three">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="villa-details-sidebar">
                            <div class="villa-details-sidebar__booking">
                                <h4 class="villa-details-sidebar__booking__title">Request to rent item</h4>
                                <form class="villa-details-sidebar__form" action="rent-items.php" method="POST">
                                    <div class="villa-details-sidebar__control">
                                        <label for="event">Rent Item <span class="text-danger">*</span></label>
                                        <select class="form-control" id="event" name="event" required>
                                            <option value="">Select Item</option>
                                            <?php foreach ($items as $item): ?>
                                            <option value="<?php echo $item['item_id']; ?>" data-fee="<?php echo $item['item_fee']; ?>">
                                                <?php echo htmlspecialchars($item['item_name']); ?> (<?php echo $item['item_fee']; ?> /hr)
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="villa-details-sidebar__control">
                                        <label for="hours">Rent Hours <span class="text-danger">*</span></label>
                                        <select class="form-control" id="hours" name="hours" required>
                                            <option value="">Select Hours</option>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?> hour<?php echo $i > 1 ? 's' : ''; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="villa-details-sidebar__control">
                                        <label>Total Cost</label>
                                        <p id="total-cost" class="form-control-static">0.00</p>
                                    </div>
                                    <input type="hidden" name="action" value="request">
                                    <button type="submit" class="villoz-btn">
                                        <i>Request Now</i>
                                        <span>Request Now</span>
                                    </button>
                                </form>
                                <?php if (isset($total_cost) && $total_cost > 0): ?>
                                <div class="villa-details-sidebar__total mt-3">
                                    <p><strong>Total Cost on Submission:</strong> <?php echo number_format($total_cost, 2); ?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include('views/view.footer.php'); ?>
    </div>
    
    <?php include('views/view.script.php'); ?>
    <script>
        const itemSelect = document.getElementById('event');
        const hoursSelect = document.getElementById('hours');
        const totalCostDisplay = document.getElementById('total-cost');

        function updateTotalCost() {
            const itemFee = parseFloat(itemSelect.selectedOptions[0]?.dataset.fee || 0);
            const hours = parseInt(hoursSelect.value || 0);
            const total = itemFee * hours;
            totalCostDisplay.textContent = total.toFixed(2);
        }

        itemSelect.addEventListener('change', updateTotalCost);
        hoursSelect.addEventListener('change', updateTotalCost);
    </script>
</body>

<style>
.villa-details-sidebar__booking {
    background: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.villa-details-sidebar__form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.villa-details-sidebar__control {
    display: flex;
    flex-direction: column;
}

.villa-details-sidebar__control label {
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
}

.form-control {
    padding: 10px;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    font-size: 1em;
    width: 100%;
}

.form-control-static {
    padding: 10px;
    font-size: 1.2em;
    font-weight: bold;
    color: #4a90e2;
}

.villoz-btn {
    background: #4a90e2;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.villoz-btn:hover {
    background: #357abd;
}

.villa-details-sidebar__total {
    padding: 10px;
    background: #f9f9f9;
    border-radius: 5px;
    text-align: center;
}

@media (max-width: 600px) {
    .villa-details-sidebar__booking {
        padding: 15px;
    }

    .form-control, .villoz-btn {
        font-size: 0.9em;
    }
}
</style>

</html>