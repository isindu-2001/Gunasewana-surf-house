<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../app/main.php";
    $conn = db_connect();
    header('Content-Type: application/json');
    
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $event_name = trim($_POST['event_name']);
        $event_description = trim($_POST['event_description']);
        if (empty($event_name)) {
            echo json_encode(['success' => false, 'message' => 'Event name is required']);
            exit;
        }
        $query = "INSERT INTO events (event_name, event_description) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $event_name, $event_description);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Event added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add event: ' . mysqli_error($conn)]);
        }
        mysqli_stmt_close($stmt);
        exit;
    }
    
    if (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $event_id = intval($_POST['event_id']);
        $event_name = trim($_POST['event_name']);
        $event_description = trim($_POST['event_description']);
        if ($event_id <= 0 || empty($event_name)) {
            echo json_encode(['success' => false, 'message' => 'Invalid event ID or name']);
            exit;
        }
        $query = "UPDATE events SET event_name = ?, event_description = ? WHERE event_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssi', $event_name, $event_description, $event_id);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Event updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update event: ' . mysqli_error($conn)]);
        }
        mysqli_stmt_close($stmt);
        exit;
    }
    
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $event_id = intval($_POST['event_id']);
        if ($event_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid event ID']);
            exit;
        }
        $query = "DELETE FROM events WHERE event_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $event_id);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Event deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete event: ' . mysqli_error($conn)]);
        }
        mysqli_stmt_close($stmt);
        exit;
    }
} else {
    include "layouts/layout.head.php";
    $conn = db_connect();

}

$query = "SELECT event_id, event_name, event_description, created_at FROM events ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<body>
    <?php include "layouts/layout.navbar.php"; ?>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Manage Events</h3>
                        <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addEventModal">
                            <i class="bi bi-plus-circle me-1"></i> Add Event
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">Event ID</th>
                                        <th class="text-center">Event Name</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Created At</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlspecialchars($row['event_id']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['event_name']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['event_description'] ?: '-'); ?></td>
                                        <td class="text-center"><?php echo date('d M Y H:i', strtotime($row['created_at'])); ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm edit-event" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editEventModal"
                                                    data-event-id="<?php echo $row['event_id']; ?>"
                                                    data-event-name="<?php echo htmlspecialchars($row['event_name']); ?>"
                                                    data-event-description="<?php echo htmlspecialchars($row['event_description'] ?: ''); ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm delete-event" 
                                                    data-event-id="<?php echo $row['event_id']; ?>">
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

    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addEventForm">
                        <div class="mb-3">
                            <label for="add_event_name" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="add_event_name" name="event_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_event_description" class="form-label">Description</label>
                            <textarea class="form-control" id="add_event_description" name="event_description" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editEventForm">
                        <input type="hidden" id="edit_event_id" name="event_id">
                        <div class="mb-3">
                            <label for="edit_event_name" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="edit_event_name" name="event_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_event_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_event_description" name="event_description" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Event</button>
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
            document.getElementById('addEventForm').addEventListener('submit', function(e) {
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

            document.querySelectorAll('.edit-event').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('edit_event_id').value = this.dataset.eventId;
                    document.getElementById('edit_event_name').value = this.dataset.eventName;
                    document.getElementById('edit_event_description').value = this.dataset.eventDescription;
                });
            });

            document.getElementById('editEventForm').addEventListener('submit', function(e) {
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

            document.querySelectorAll('.delete-event').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete this event?')) {
                        const formData = new FormData();
                        formData.append('action', 'delete');
                        formData.append('event_id', this.dataset.eventId);
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