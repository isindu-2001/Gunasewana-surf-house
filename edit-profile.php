<?php include 'views/view.head.php'; ?>
<?php
$user_id = $users->getID();
$user = $users->getUser($user_id);

if (!$user) {
    header('Location: index.php?error=User not found&type=error');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);

    // Validation
    $errors = [];
    if (empty($firstName)) $errors[] = "First Name is required.";
    if (empty($lastName)) $errors[] = "Last Name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid Email is required.";
    if (empty($mobile) || !preg_match("/^[0-9]{10}$/", $mobile)) $errors[] = "Valid 10-digit Mobile Number is required.";

    if (empty($errors)) {
        if ($users->updateUser($user_id, $firstName, $lastName, $email, $mobile)) {
            redirect('edit-profile.php?error=Profile updated successfully&type=success');
            exit;
        } else {
            $errors[] = "Failed to update profile. Please try again.";
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
                    <li><span class="text-white">Edit Profile</span></li>
                </ul>
                <h2 class="page-header__title text-white fw-bold">Edit Profile</h2>
            </div>
        </section>

        <section class="profile-edit py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-body p-5">
                                <h3 class="card-title mb-4 text-primary fw-bold">Profile Information</h3>

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

                                <form method="POST" action="edit-profile.php" class="contact-form">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label for="firstName" class="form-label fw-medium">First Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-user"></i></span>
                                                <input type="text" class="form-control rounded-end" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user['user_firstName']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastName" class="form-label fw-medium">Last Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-user"></i></span>
                                                <input type="text" class="form-control rounded-end" id="lastName" name="lastName" value="<?php echo htmlspecialchars($user['user_lastName']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label fw-medium">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-envelope"></i></span>
                                                <input type="email" class="form-control rounded-end" id="email" name="email" value="<?php echo htmlspecialchars($user['user_email']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="mobile" class="form-label fw-medium">Mobile Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-phone"></i></span>
                                                <input type="text" class="form-control rounded-end" id="mobile" name="mobile" value="<?php echo htmlspecialchars($user['user_mobile']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="created_at" class="form-label fw-medium">Account Created</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-calendar-alt"></i></span>
                                                <input type="text" class="form-control rounded-end" id="created_at" value="<?php echo htmlspecialchars($user['created_at']); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">
                                                <i class="fas fa-save me-2"></i>Save Changes
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