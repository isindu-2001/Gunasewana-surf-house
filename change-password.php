<?php include 'views/view.head.php'; ?>
<?php
$user_id = $users->getID();
$user = $users->getUser($user_id);

if (!$user) {
    header('Location: index.php?error=User not found&type=error');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = trim($_POST['old_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    $errors = [];
    if (empty($old_password)) $errors[] = "Old Password is required.";
    if (empty($new_password)) $errors[] = "New Password is required.";
    if (empty($confirm_password)) $errors[] = "Confirm Password is required.";
    if ($new_password !== $confirm_password) $errors[] = "New Password and Confirm Password do not match.";
    if (strlen($new_password) < 8) $errors[] = "New Password must be at least 8 characters long.";
    if (!preg_match("/[A-Z]/", $new_password) || !preg_match("/[0-9]/", $new_password)) {
        $errors[] = "New Password must include at least one uppercase letter and one number.";
    }
    if (!$users->verifyPassword($user_id, $old_password)) {
        $errors[] = "Old Password is incorrect.";
    }

    if (empty($errors)) {
        if ($users->updatePassword($user_id, $new_password)) {
            redirect('change-password.php?error=Password updated successfully&type=success');
            exit;
        } else {
            $errors[] = "Failed to update password. Please try again.";
        }
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
            <?php include 'views/view.topbar.php'; ?>
            <?php include 'views/view.header.php'; ?>
        </div>

        <section class="page-header" style="background: linear-gradient(135deg, #1e3c72, #2a5298);">
            <div class="container text-center py-5">
                <ul class="villoz-breadcrumb list-unstyled d-flex justify-content-center mb-3">
                    <li><a href="index.php" class="text-white">Home</a></li>
                    <li class="mx-2 text-white">/</li>
                    <li><a href="profile.php" class="text-white">My Profile</a></li>
                    <li class="mx-2 text-white">/</li>
                    <li><span class="text-white">Change Password</span></li>
                </ul>
                <h2 class="page-header__title text-white fw-bold">Change Password</h2>
            </div>
        </section>

        <section class="profile-edit py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-body p-5">
                                <h3 class="card-title mb-4 text-primary fw-bold">Update Your Password</h3>

                                <?php if (isset($_GET['success'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                                        <?php echo htmlspecialchars($_GET['success']); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($errors)): ?>
                                    <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                                        <ul class="mb-0">
                                            <?php foreach ($errors as $error): ?>
                                                <li><?php echo htmlspecialchars($error); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <form method="POST" action="change-password.php" class="contact-form-">
                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <label for="old_password" class="form-label fw-medium">Old Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-lock"></i></span>
                                                <input type="password" class="form-control rounded-end" id="old_password" name="old_password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="new_password" class="form-label fw-medium">New Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-lock"></i></span>
                                                <input type="password" class="form-control rounded-end" id="new_password" name="new_password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="confirm_password" class="form-label fw-medium">Confirm New Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-lock"></i></span>
                                                <input type="password" class="form-control rounded-end" id="confirm_password" name="confirm_password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">
                                                <i class="fas fa-save me-2"></i>Update Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include 'views/view.footer.php'; ?>
    </div>

    <?php include 'views/view.script.php'; ?>
</body>
</html>