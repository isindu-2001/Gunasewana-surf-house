<?php 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../app/main.php";
    $conn = db_connect();
    header('Content-Type: application/json');
    
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $item_name = trim($_POST['item_name']);
        $item_fee = floatval($_POST['item_fee']);
        $item_description = trim($_POST['item_description']);
        if (empty($item_name)) {
            echo json_encode(['success' => false, 'message' => 'Item name is required']);
            exit;
        }
        if ($item_fee < 0) {
            echo json_encode(['success' => false, 'message' => 'Item fee cannot be negative']);
            exit;
        }
        $query = "INSERT INTO rent_items (item_name, item_fee, item_description) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'sds', $item_name, $item_fee, $item_description);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Item added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add item: ' . mysqli_error($conn)]);
        }
        mysqli_stmt_close($stmt);
        exit;
    }
    
    if (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $item_id = intval($_POST['item_id']);
        $item_name = trim($_POST['item_name']);
        $item_fee = floatval($_POST['item_fee']);
        $item_description = trim($_POST['item_description']);
        if ($item_id <= 0 || empty($item_name)) {
            echo json_encode(['success' => false, 'message' => 'Invalid item ID or name']);
            exit;
        }
        if ($item_fee < 0) {
            echo json_encode(['success' => false, 'message' => 'Item fee cannot be negative']);
            exit;
        }
        $query = "UPDATE rent_items SET item_name = ?, item_fee = ?, item_description = ? WHERE item_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'sdsi', $item_name, $item_fee, $item_description, $item_id);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Item updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update item: ' . mysqli_error($conn)]);
        }
        mysqli_stmt_close($stmt);
        exit;
    }
    
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $item_id = intval($_POST['item_id']);
        if ($item_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid item ID']);
            exit;
        }
        $query = "DELETE FROM rent_items WHERE item_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $item_id);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Item deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete item: ' . mysqli_error($conn)]);
        }
        mysqli_stmt_close($stmt);
        exit;
    }
} else {
    include "layouts/layout.head.php";
    $conn = db_connect();
}

$query = "SELECT item_id, item_name, item_fee, item_description, created_at FROM rent_items ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<body>
    <?php include "layouts/layout.navbar.php"; ?>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Manage Rent Items</h3>
                        <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">
                            <i class="bi bi-plus-circle me-1"></i> Add Item
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">Item ID</th>
                                        <th class="text-center">Item Name</th>
                                        <th class="text-center">Fee</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Created At</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlspecialchars($row['item_id']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['item_name']); ?></td>
                                        <td class="text-center"> LKR <?php echo number_format($row['item_fee'], 2); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['item_description'] ?: '-'); ?></td>
                                        <td class="text-center"><?php echo date('d M Y H:i', strtotime($row['created_at'])); ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm edit-item" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editItemModal"
                                                    data-item-id="<?php echo $row['item_id']; ?>"
                                                    data-item-name="<?php echo htmlspecialchars($row['item_name']); ?>"
                                                    data-item-fee="<?php echo htmlspecialchars($row['item_fee']); ?>"
                                                    data-item-description="<?php echo htmlspecialchars($row['item_description'] ?: ''); ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm delete-item" 
                                                    data-item-id="<?php echo $row['item_id']; ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
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

    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addItemModalLabel">Add New Rent Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addItemForm">
                        <div class="mb-3">
                            <label for="add_item_name" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="add_item_name" name="item_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_item_fee" class="form-label">Fee</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="add_item_fee" name="item_fee" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_item_description" class="form-label">Description</label>
                            <textarea class="form-control" id="add_item_description" name="item_description" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editItemModalLabel">Edit Rent Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editItemForm">
                        <input type="hidden" id="edit_item_id" name="item_id">
                        <div class="mb-3">
                            <label for="edit_item_name" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="edit_item_name" name="item_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_item_fee" class="form-label">Fee</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="edit_item_fee" name="item_fee" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_item_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_item_description" name="item_description" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Item</button>
                    </form>
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
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addItemForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('action', 'add');
                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => alert('Error: ' + error.message));
            });

            document.querySelectorAll('.edit-item').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('edit_item_id').value = this.dataset.itemId;
                    document.getElementById('edit_item_name').value = this.dataset.itemName;
                    document.getElementById('edit_item_fee').value = this.dataset.itemFee;
                    document.getElementById('edit_item_description').value = this.dataset.itemDescription;
                });
            });

            document.getElementById('editItemForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('action', 'edit');
                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => alert('Error: ' + error.message));
            });

            document.querySelectorAll('.delete-item').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete this item?')) {
                        const formData = new FormData();
                        formData.append('action', 'delete');
                        formData.append('item_id', this.dataset.itemId);
                        fetch(window.location.href, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                window.location.reload();
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(error => alert('Error: ' + error.message));
                    }
                });
            });
        });
    </script>
</body>
</html>